<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

use App\Models\Penjualan;
use App\Models\PenjualanProduk;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DasborController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Adjust for WIT timezone (UTC+9)
        $today = Carbon::today('Asia/Jayapura');
        $oneWeekAgo = $today->copy()->subDays(6); // 7 days including today

        // Total Sales Today
        $totalSales = Penjualan::whereDate('tanggal_penjualan', $today)
            ->count();

        // Total Revenue Today
        $totalRevenue = Penjualan::whereDate('tanggal_penjualan', $today)
            ->sum('total_akhir');

        // Total Products
        $totalProducts = Produk::where('aktif', 1)
            ->count();

        // Low Stock Products
        $lowStock = Produk::where('aktif', 1)
            ->whereColumn('jumlah_stok', '<=', 'stok_minimum')
            ->count();

        // Weekly Sales Data (last 7 days including today)
        $weeklySales = Penjualan::select(
            DB::raw('DATE(tanggal_penjualan) as date'),
            DB::raw('SUM(total_akhir) as total')
        )
            ->whereBetween('tanggal_penjualan', [$oneWeekAgo, $today->copy()->endOfDay()])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Create complete 7-day data array
        $salesChartData = [];
        $labels = [];
        $dayLabels = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        // Generate data for each day in the past 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $dateString = $date->format('Y-m-d');
            $dayOfWeek = $date->dayOfWeek; // 0 = Sunday, 6 = Saturday
            
            // Create label with day name and date
            $dayLabel = $dayLabels[$dayOfWeek];
            $dateLabel = $date->format('d/m');
            
            if ($i === 0) {
                $labels[] = "Hari Ini ({$dateLabel})";
            } else {
                $labels[] = "{$dayLabel} ({$dateLabel})";
            }
            
            // Get sales data for this date
            $salesChartData[] = isset($weeklySales[$dateString]) 
                ? (float) $weeklySales[$dateString]->total 
                : 0;
        }

        // Top 5 Products (based on quantity sold in last 30 days)
        $topProducts = PenjualanProduk::select(
            'penjualan_produks.nama',
            DB::raw('SUM(penjualan_produks.jumlah) as total_sold')
        )
            ->join('penjualans', 'penjualan_produks.penjualan_id', '=', 'penjualans.id')
            ->where('penjualans.tanggal_penjualan', '>=', $today->copy()->subDays(30))
            ->groupBy('penjualan_produks.nama')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        // Repeat Order Customers (customers with multiple purchases in last 30 days)
        $repeatCustomers = Penjualan::select(
            'pelanggans.nama',
            DB::raw('COUNT(penjualans.id) as purchase_count')
        )
            ->join('pelanggans', 'penjualans.pelanggan_id', '=', 'pelanggans.id')
            ->where('penjualans.tanggal_penjualan', '>=', $today->copy()->subDays(30))
            ->groupBy('pelanggans.id', 'pelanggans.nama')
            ->having('purchase_count', '>', 1)
            ->orderBy('purchase_count', 'desc')
            ->take(5)
            ->get();

        // Low Stock Products (products with stock <= minimum stock)
        $lowStockProducts = Produk::select(
            'nama',
            'jumlah_stok'
        )
            ->where('aktif', 1)
            ->whereColumn('jumlah_stok', '<=', 'stok_minimum')
            ->orderBy('jumlah_stok', 'asc')
            ->take(5)
            ->get();

        // Calculate week comparison
        $thisWeekTotal = array_sum($salesChartData);
        $lastWeekTotal = Penjualan::whereBetween('tanggal_penjualan', [
            $today->copy()->subDays(13),
            $today->copy()->subDays(7)
        ])->sum('total_akhir');
        
        $weekGrowth = $lastWeekTotal > 0 
            ? (($thisWeekTotal - $lastWeekTotal) / $lastWeekTotal) * 100 
            : 0;

        // Format data for view
        $chartData = [
            'labels' => $labels,
            'salesData' => $salesChartData,
            'weekGrowth' => round($weekGrowth, 1),
            'topProducts' => [
                'labels' => $topProducts->pluck('nama')->toArray(),
                'data' => $topProducts->pluck('total_sold')->toArray()
            ],
            'repeatCustomers' => [
                'labels' => $repeatCustomers->pluck('nama')->toArray(),
                'data' => $repeatCustomers->pluck('purchase_count')->toArray()
            ],
            'lowStockProducts' => [
                'labels' => $lowStockProducts->pluck('nama')->toArray(),
                'data' => $lowStockProducts->pluck('jumlah_stok')->toArray()
            ]
        ];

        return view('home', compact(
            'totalSales',
            'totalRevenue',
            'totalProducts',
            'lowStock',
            'chartData',
        ));
    }

    // Rest of the methods remain the same...
    public function profile()
    {
        $auth = Auth::user();
        $user = User::find($auth->id);
        return view('profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $auth = Auth::user();
        $user = User::find($auth->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            $avatarName = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->storeAs('public/avatars', $avatarName);
            $user->avatar = $avatarName;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile berhasil diperbarui!');
    }

    public function settings()
    {
        return view('settings');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $auth = Auth::user();
        $user = User::find($auth->id);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password lama tidak sesuai.'])
                ->withInput();
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('settings')->with('success', 'Password berhasil diperbarui!');
    }

    public function updateNotificationSettings(Request $request)
    {
        $auth = Auth::user();
        $user = User::find($auth->id);

        $user->email_notifications = $request->has('email_notifications');
        $user->push_notifications = $request->has('push_notifications');
        $user->sms_notifications = $request->has('sms_notifications');
        $user->save();

        return redirect()->route('settings')->with('success', 'Pengaturan notifikasi berhasil diperbarui!');
    }
}