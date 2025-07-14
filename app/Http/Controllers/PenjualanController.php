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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $penjualans = Penjualan::with(['pelanggan'])
            //     ->orderBy('tanggal_penjualan', 'desc')
            //     ->select(['id', 'kode_penjualan', 'tanggal_penjualan', 'nama_pelanggan', 'total_akhir', 'status_pembayaran']);

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
            'metode_pembayaran' => 'required|in:tunai,transfer,kartu_kredit,kartu_debit,e_wallet',
            // 'status_pembayaran' => 'required|in:lunas,belum_lunas,sebagian',
            'status_pengiriman' => 'in:belum_dikirim,sedang_dikirim,sudah_dikirim',
            'produks' => 'required|array|min:1',
            'produks.*.barang_id' => 'required|exists:produks,id',
            'produks.*.jumlah' => 'required|numeric|min:0.001',
            'produks.*.harga_jual' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try {
            DB::beginTransaction();

            $penjualan = new Penjualan();
            $penjualan->kode_penjualan = 'PJ-' . date('Ymd') . '-' . Str::upper(Str::random(6));
            $penjualan->tanggal_penjualan = now()->toDateString();
            $penjualan->waktu_penjualan = now()->toTimeString();
            $penjualan->pelanggan_id = $request->pelanggan_id;
            $penjualan->user_id = auth()->id();
            $penjualan->metode_pembayaran = $request->metode_pembayaran;
            // $penjualan->status_pembayaran = $request->status_pembayaran;
            $penjualan->status_pengiriman = 'belum_dikirim';

            $subtotal = 0;
            foreach ($request->produks as $item) {
                $produk = Produk::findOrFail($item['barang_id']);
                $subtotal += $item['harga_jual'] * $item['jumlah'];
            }

            $penjualan->subtotal = $subtotal;
            $penjualan->total_akhir = $subtotal;
            $penjualan->jumlah_bayar = $request->status_pembayaran === 'lunas' ? $subtotal : 0;
            $penjualan->kembalian = $penjualan->jumlah_bayar - $penjualan->total_akhir;
            $penjualan->save();

            foreach ($request->produks as $item) {
                $produk = Produk::findOrFail($item['barang_id']);
                $penjualanProduk = new PenjualanProduk();
                $penjualanProduk->penjualan_id = $penjualan->id;
                $penjualanProduk->barang_id = $item['barang_id'];
                $penjualanProduk->kode_sku = $produk->kode_sku;
                $penjualanProduk->nama = $produk->nama;
                $penjualanProduk->satuan = $produk->satuan;
                $penjualanProduk->harga_jual = $item['harga_jual'];
                $penjualanProduk->harga_jual_asli = $item['harga_jual'];
                $penjualanProduk->jumlah = $item['jumlah'];
                $penjualanProduk->harga_setelah_diskon = $item['harga_jual'];
                $penjualanProduk->subtotal = $item['harga_jual'] * $item['jumlah'];
                $penjualanProduk->save();
            }

            DB::commit();

            return redirect()->route('penjualans.index')->with('success', 'Penjualan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        return view('penjualans.edit', compact('penjualan', 'pelanggans', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'pelanggan_id' => 'nullable|exists:pelanggans,id',
            'metode_pembayaran' => 'in:tunai,transfer,kartu_kredit,kartu_debit,e_wallet',
            // 'status_pembayaran' => 'in:lunas,belum_lunas,sebagian',
            'status_pengiriman' => 'in:belum_dikirim,sedang_dikirim,sudah_dikirim',
            'produks' => 'required|array|min:1',
            'produks.*.barang_id' => 'required|exists:produks,id',
            'produks.*.jumlah' => 'required|numeric|min:0.001',
            'produks.*.harga_jual' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $penjualan->fill($request->only([
                'pelanggan_id',
                'metode_pembayaran',
                'status_pembayaran',
                'status_pengiriman',
            ]));

            // if ($request->status_pembayaran === 'lunas') {
            //     $penjualan->jumlah_bayar = $penjualan->total_akhir;
            //     $penjualan->kembalian = 0;
            // }

            $subtotal = 0;
            foreach ($request->produks as $item) {
                $produk = Produk::findOrFail($item['barang_id']);
                $subtotal += $item['harga_jual'] * $item['jumlah'];
            }

            $penjualan->subtotal = $subtotal;
            $penjualan->total_akhir = $subtotal;
            // $penjualan->jumlah_bayar = $request->status_pembayaran === 'lunas' ? $subtotal : $request->jumlah_bayar;
            $penjualan->jumlah_bayar = $request->jumlah_bayar;
            $penjualan->kembalian = $penjualan->jumlah_bayar - $penjualan->total_akhir;
            $penjualan->save();

            PenjualanProduk::where('penjualan_id', $penjualan->id)->delete();

            $subtotal = 0;
            foreach ($request->produks as $item) {
                $produk = Produk::findOrFail($item['barang_id']);
                $subtotal += $item['harga_jual'] * $item['jumlah'];

                $penjualanProduk = new PenjualanProduk();
                $penjualanProduk->penjualan_id = $penjualan->id;
                $penjualanProduk->barang_id = $item['barang_id'];
                $penjualanProduk->kode_sku = $produk->kode_sku;
                $penjualanProduk->nama = $produk->nama;
                $penjualanProduk->satuan = $produk->satuan;
                $penjualanProduk->harga_jual = $item['harga_jual'];
                $penjualanProduk->harga_jual_asli = $item['harga_jual'];
                $penjualanProduk->jumlah = $item['jumlah'];
                $penjualanProduk->harga_setelah_diskon = $item['harga_jual'];
                $penjualanProduk->subtotal = $item['harga_jual'] * $item['jumlah'];
                $penjualanProduk->save();
            }

            $penjualan->save();

            DB::commit();

            return redirect()->route('penjualans.index')->with('success', 'Penjualan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
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
