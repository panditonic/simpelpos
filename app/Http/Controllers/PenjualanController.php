<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanProduk;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $penjualans = Penjualan::with(['pelanggan'])
                ->leftJoin('pelanggans', 'penjualans.pelanggan_id', '=', 'pelanggans.id')
                ->orderBy('penjualans.tanggal_penjualan', 'desc')
                ->select([
                    'penjualans.id',
                    'penjualans.kode_penjualan',
                    'penjualans.tanggal_penjualan',
                    'penjualans.waktu_penjualan',
                    'pelanggans.nama as nama_pelanggan',
                    'penjualans.total_akhir',
                    'penjualans.jumlah_bayar',
                    'penjualans.kembalian',
                    'penjualans.metode_pembayaran',
                    'penjualans.status_pembayaran',
                    'penjualans.status_pengiriman',
                ])
                ->get();

            return datatables()->of($penjualans)->toJson();
        }
        return view('penjualans.index');
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        return view('penjualans.create', compact('pelanggans', 'produks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pelanggan_id' => 'nullable|exists:pelanggans,id',
            'kode_penjualan' => 'required|string|unique:penjualans,kode_penjualan',
            'tanggal_penjualan' => 'required|date',
            'waktu_penjualan' => 'required',
            'catatan' => 'nullable|string',
            'nama_pelanggan' => 'nullable|string|max:255',
            'telepon_pelanggan' => 'nullable|string|max:20',
            'alamat_pelanggan' => 'nullable|string',
            'metode_pembayaran' => 'required|in:tunai,transfer,kartu_kredit,kartu_debit,e_wallet',
            'referensi_pembayaran' => 'nullable|string|max:255',
            'status_pembayaran' => 'required|in:lunas,belum_lunas,sebagian',
            'status_pengiriman' => 'required|in:belum_dikirim,sedang_dikirim,sudah_dikirim',
            'jumlah_bayar' => 'required|numeric|min:0',
            'diskon_persen' => 'nullable|numeric|min:0|max:100',
            'pajak_persen' => 'nullable|numeric|min:0|max:100',
            'biaya_pengiriman' => 'nullable|numeric|min:0',
            'produks' => 'required|array|min:1',
            'produks.*.barang_id' => 'required|exists:produks,id',
            'produks.*.jumlah' => 'required|numeric|min:0.001',
            'produks.*.harga_jual' => 'required|numeric|min:0',
            'produks.*.harga_jual_asli' => 'required|numeric|min:0',
            'produks.*.harga_modal' => 'required|numeric|min:0',
            'produks.*.diskon_persen' => 'nullable|numeric|min:0|max:100',
            'produks.*.harga_setelah_diskon' => 'required|numeric|min:0',
            'produks.*.subtotal' => 'required|numeric|min:0',
            'produks.*.berat' => 'nullable|numeric|min:0',
            'produks.*.catatan_item' => 'nullable|string',
            'produks.*.laba_per_item' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $penjualan = new Penjualan();
            $penjualan->kode_penjualan = $request->kode_penjualan;
            $penjualan->tanggal_penjualan = $request->tanggal_penjualan;
            $penjualan->waktu_penjualan = $request->waktu_penjualan;
            $penjualan->pelanggan_id = $request->pelanggan_id;
            $penjualan->nama_pelanggan = $request->nama_pelanggan;
            $penjualan->telepon_pelanggan = $request->telepon_pelanggan;
            $penjualan->alamat_pelanggan = $request->alamat_pelanggan;
            $penjualan->user_id = auth()->id();
            $penjualan->metode_pembayaran = $request->metode_pembayaran;
            $penjualan->referensi_pembayaran = $request->referensi_pembayaran;
            $penjualan->status_pembayaran = $request->status_pembayaran;
            $penjualan->status_pengiriman = $request->status_pengiriman;
            $penjualan->catatan = $request->catatan;

            // Calculate subtotal
            $subtotal = 0;
            foreach ($request->produks as $item) {
                $subtotal += $item['subtotal'];
            }

            // Calculate discounts, taxes, and final total
            $diskonPersen = $request->diskon_persen ?? 0;
            $pajakPersen = $request->pajak_persen ?? 0;
            $biayaPengiriman = $request->biaya_pengiriman ?? 0;

            $diskonNominal = ($subtotal * $diskonPersen) / 100;
            $pajakNominal = ($subtotal * $pajakPersen) / 100;
            $totalAkhir = $subtotal - $diskonNominal + $pajakNominal + $biayaPengiriman;

            $penjualan->subtotal = $subtotal;
            $penjualan->diskon_persen = $diskonPersen;
            $penjualan->diskon_nominal = $diskonNominal;
            $penjualan->pajak_persen = $pajakPersen;
            $penjualan->pajak_nominal = $pajakNominal;
            $penjualan->biaya_pengiriman = $biayaPengiriman;
            $penjualan->total_akhir = $totalAkhir;
            $penjualan->jumlah_bayar = $request->jumlah_bayar;
            $penjualan->kembalian = $request->jumlah_bayar - $totalAkhir;

            $penjualan->save();

            foreach ($request->produks as $item) {
                $produk = Produk::findOrFail($item['barang_id']);
                $penjualanProduk = new PenjualanProduk();
                $penjualanProduk->penjualan_id = $penjualan->id;
                $penjualanProduk->barang_id = $item['barang_id'];
                $penjualanProduk->kode_sku = $produk->kode_sku;
                $penjualanProduk->nama = $produk->nama;
                $penjualanProduk->satuan = $produk->satuan;
                $penjualanProduk->jumlah = $item['jumlah'];
                $penjualanProduk->harga_jual = $item['harga_jual'];
                $penjualanProduk->harga_jual_asli = $item['harga_jual_asli'];
                $penjualanProduk->harga_modal = $item['harga_modal'];
                $penjualanProduk->diskon_persen = $item['diskon_persen'] ?? 0;
                $penjualanProduk->diskon_nominal = ($item['harga_jual'] * $item['jumlah'] * ($item['diskon_persen'] ?? 0)) / 100; // Calculate per-item discount
                $penjualanProduk->harga_setelah_diskon = $item['harga_setelah_diskon'];
                $penjualanProduk->subtotal = $item['subtotal'];
                $penjualanProduk->berat = $item['berat'] ?? 0;
                $penjualanProduk->catatan_item = $item['catatan_item'] ?? '';
                $penjualanProduk->laba_per_item = $item['laba_per_item'];
                $penjualanProduk->save();
            }

            DB::commit();
            return redirect()->route('penjualans.index')->with('success', 'Penjualan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan penjualan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $penjualan = Penjualan::with('produks')->findOrFail($id);
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        return view('penjualans.edit', compact('penjualan', 'pelanggans', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $penjualan = Penjualan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'kode_penjualan' => 'required|string|max:255|unique:penjualans,kode_penjualan,' . $id,
            'tanggal_penjualan' => 'required|date',
            'waktu_penjualan' => 'required|date_format:H:i:s',
            'catatan' => 'nullable|string',
            'pelanggan_id' => 'nullable|exists:pelanggans,id',
            'nama_pelanggan' => 'nullable|string|max:255',
            'telepon_pelanggan' => 'nullable|string|max:255',
            'alamat_pelanggan' => 'nullable|string',
            'metode_pembayaran' => 'required|in:tunai,transfer,kartu_kredit,kartu_debit,e_wallet',
            'referensi_pembayaran' => 'nullable|string|max:255',
            'status_pengiriman' => 'required|in:belum_dikirim,sedang_dikirim,sudah_dikirim',
            'status_pembayaran' => 'required|in:lunas,belum_lunas,sebagian',
            'jumlah_bayar' => 'required|numeric|min:0',
            'diskon_persen' => 'required|numeric|min:0|max:100',
            'pajak_persen' => 'required|numeric|min:0|max:100',
            'biaya_pengiriman' => 'required|numeric|min:0',
            'produks' => 'required|array|min:1',
            'produks.*.barang_id' => 'required|exists:produks,id',
            'produks.*.jumlah' => 'required|numeric|min:0.001',
            'produks.*.harga_jual' => 'required|numeric|min:0',
            'produks.*.harga_modal' => 'nullable|numeric|min:0',
            'produks.*.diskon_persen' => 'required|numeric|min:0|max:100',
            'produks.*.harga_setelah_diskon' => 'nullable|numeric|min:0',
            'produks.*.subtotal' => 'nullable|numeric|min:0',
            'produks.*.laba_per_item' => 'nullable|numeric',
            'produks.*.berat' => 'nullable|numeric|min:0',
            'produks.*.catatan_item' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Update Penjualan fields
            $penjualan->fill($request->only([
                'kode_penjualan',
                'tanggal_penjualan',
                'waktu_penjualan',
                'catatan',
                'pelanggan_id',
                'nama_pelanggan',
                'telepon_pelanggan',
                'alamat_pelanggan',
                'metode_pembayaran',
                'referensi_pembayaran',
                'status_pengiriman',
                'status_pembayaran',
                'jumlah_bayar',
                'diskon_persen',
                'pajak_persen',
                'biaya_pengiriman',
            ]));

            // Calculate totals
            $subtotal = 0;
            foreach ($request->produks as $item) {
                $produk = Produk::findOrFail($item['barang_id']);
                $harga_setelah_diskon = $item['harga_jual'] * (1 - $item['diskon_persen'] / 100);
                $subtotal += $harga_setelah_diskon * $item['jumlah'];
            }

            $penjualan->subtotal = $subtotal;
            $penjualan->diskon_nominal = $subtotal * ($request->diskon_persen / 100);
            $subtotal_setelah_diskon = $subtotal - $penjualan->diskon_nominal;
            $penjualan->pajak_nominal = $subtotal_setelah_diskon * ($request->pajak_persen / 100);
            $penjualan->total_akhir = $subtotal_setelah_diskon + $penjualan->pajak_nominal + $request->biaya_pengiriman;
            $penjualan->kembalian = $request->status_pembayaran === 'lunas' ? 0 : $request->jumlah_bayar - $penjualan->total_akhir;

            $penjualan->save();

            // Delete existing PenjualanProduk records
            PenjualanProduk::where('penjualan_id', $penjualan->id)->delete();

            // Save new PenjualanProduk records
            foreach ($request->produks as $index => $item) {
                $produk = Produk::findOrFail($item['barang_id']);
                $harga_setelah_diskon = $item['harga_jual'] * (1 - $item['diskon_persen'] / 100);
                $subtotal_item = $harga_setelah_diskon * $item['jumlah'];
                $diskon_nominal_item = ($item['harga_jual'] * $item['jumlah'] * $item['diskon_persen']) / 100; // Calculate per-item discount
                $laba_per_item = $item['harga_modal'] ? ($harga_setelah_diskon - $item['harga_modal']) * $item['jumlah'] : 0;

                $penjualanProduk = new PenjualanProduk();
                $penjualanProduk->penjualan_id = $penjualan->id;
                $penjualanProduk->barang_id = $item['barang_id'];
                $penjualanProduk->kode_sku = $produk->kode_sku;
                $penjualanProduk->nama = $produk->nama;
                $penjualanProduk->satuan = $produk->satuan;
                $penjualanProduk->harga_jual = $item['harga_jual'];
                $penjualanProduk->harga_jual_asli = $item['harga_jual'];
                $penjualanProduk->harga_modal = $item['harga_modal'] ?? 0;
                $penjualanProduk->diskon_persen = $item['diskon_persen'];
                $penjualanProduk->diskon_nominal = $diskon_nominal_item;
                $penjualanProduk->harga_setelah_diskon = $harga_setelah_diskon;
                $penjualanProduk->jumlah = $item['jumlah'];
                $penjualanProduk->subtotal = $subtotal_item;
                $penjualanProduk->laba_per_item = $laba_per_item;
                $penjualanProduk->berat = $item['berat'] ?? 0;
                $penjualanProduk->catatan_item = $item['catatan_item'];
                $penjualanProduk->save();
            }

            DB::commit();
            return redirect()->route('penjualans.index')->with('success', 'Penjualan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui penjualan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $penjualan = Penjualan::findOrFail($id);
            $penjualan->delete();

            return redirect()->route('penjualans.index')->with('success', 'Penjualan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('penjualans.index')->with('error', $e->getMessage());
        }
    }
}