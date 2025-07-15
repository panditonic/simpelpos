<?php

namespace Database\Seeders;

use App\Models\Penjualan;
use App\Models\PenjualanProduk;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        // Initialize Faker with Indonesian locale
        $faker = Faker::create('id_ID');

        // Define allowed values
        $metode_pembayaran = ['tunai', 'transfer', 'kartu_kredit', 'kartu_debit', 'e_wallet'];
        $status_pengiriman = ['belum_dikirim', 'sedang_dikirim', 'sudah_dikirim'];
        $status_pembayaran = ['lunas', 'belum_lunas', 'sebagian'];
        $promo_types = ['B1G1', 'Discount', 'Bundle'];

        // Fetch data from related tables
        $user_ids = User::pluck('id')->toArray();
        $pelanggan_ids = Pelanggan::pluck('id')->toArray();
        $produks = Produk::select('id', 'nama', 'kode_sku', 'harga_jual', 'harga_modal', 'satuan', 'berat')->get()->toArray();

        // Validate related tables
        if (empty($user_ids) || empty($pelanggan_ids) || empty($produks)) {
            throw new \Exception('Users, pelanggans, or produks table is empty. Please seed those tables first.');
        }

        // Disable foreign key checks for truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Penjualan::truncate();
        PenjualanProduk::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Generate 100 sales records
        for ($i = 0; $i < 100; $i++) {
            $subtotal = 0;
            $diskon_persen = $faker->randomFloat(2, 0, 20); // 0-20%
            $pajak_persen = $faker->randomFloat(2, 0, 11); // 0-11%
            $biaya_pengiriman = round($faker->randomFloat(2, 0, 50000), 2); // 0-50,000 IDR

            // Generate unique kode_penjualan
            $kode_penjualan = 'PJ-' . date('Ymd') . '-' . strtoupper($faker->unique()->lexify('??????'));

            // Customer info: 50% chance of using pelanggan_id, otherwise manual details
            $pelanggan_id = $faker->boolean(50) ? $faker->randomElement($pelanggan_ids) : null;
            $nama_pelanggan = $pelanggan_id ? null : $faker->name;
            $telepon_pelanggan = $pelanggan_id ? null : $faker->phoneNumber;
            $alamat_pelanggan = $pelanggan_id ? null : $faker->address;

            // Referensi pembayaran: 70% chance
            $referensi_pembayaran = $faker->boolean(70) ? $faker->bothify('REF-#####') : null;

            // Create Penjualan record
            $penjualan = new Penjualan();
            $penjualan->kode_penjualan = $kode_penjualan;
            $penjualan->tanggal_penjualan = $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d');
            $penjualan->waktu_penjualan = $faker->time('H:i:s');
            $penjualan->pelanggan_id = $pelanggan_id;
            $penjualan->nama_pelanggan = $nama_pelanggan;
            $penjualan->telepon_pelanggan = $telepon_pelanggan;
            $penjualan->alamat_pelanggan = $alamat_pelanggan;
            $penjualan->user_id = $faker->randomElement($user_ids);
            $penjualan->subtotal = 0; // To be calculated
            $penjualan->diskon_persen = $diskon_persen;
            $penjualan->diskon_nominal = 0; // To be calculated
            $penjualan->pajak_persen = $pajak_persen;
            $penjualan->pajak_nominal = 0; // To be calculated
            $penjualan->biaya_pengiriman = $biaya_pengiriman;
            $penjualan->total_akhir = 0; // To be calculated
            $penjualan->metode_pembayaran = $faker->randomElement($metode_pembayaran);
            $penjualan->jumlah_bayar = 0; // To be calculated
            $penjualan->kembalian = 0; // To be calculated
            $penjualan->status_pengiriman = $faker->randomElement($status_pengiriman);
            $penjualan->catatan = $faker->optional(0.7)->sentence; // 70% chance
            $penjualan->referensi_pembayaran = $referensi_pembayaran;
            $penjualan->created_at = now();
            $penjualan->updated_at = now();
            $penjualan->save();

            // Generate 1-5 products per sale for realism
            $num_products = $faker->numberBetween(1, 5);
            $penjualan_produks = [];

            for ($j = 0; $j < $num_products; $j++) {
                $produk = $faker->randomElement($produks);
                $jumlah = $faker->randomFloat(3, 0.001, 50); // Realistic quantity: 0.001-50
                $diskon_persen_item = $faker->randomFloat(2, 0, 30); // 0-30%
                $is_promo = $diskon_persen_item > 0 && $faker->boolean(20); // 20% chance if discounted
                $jenis_promo = $is_promo ? $faker->randomElement($promo_types) : null;

                // Realistic price ranges
                $harga_jual = min($produk['harga_jual'], 1000000); // Cap at 1M IDR
                $harga_modal = $produk['harga_modal'] ? min($produk['harga_modal'], $harga_jual * 0.8) : 0; // Ensure modal < jual

                // Calculate item values
                $diskon_nominal_per_unit = ($harga_jual * $diskon_persen_item) / 100;
                $harga_setelah_diskon = $harga_jual - $diskon_nominal_per_unit;
                $diskon_nominal_total = $diskon_nominal_per_unit * $jumlah;
                $item_subtotal = $harga_setelah_diskon * $jumlah;
                $laba_per_item = ($harga_setelah_diskon - $harga_modal) * $jumlah;

                $subtotal += $item_subtotal;

                $penjualan_produks[] = [
                    'penjualan_id' => $penjualan->id,
                    'barang_id' => $produk['id'],
                    'kode_sku' => $produk['kode_sku'],
                    'nama' => $produk['nama'],
                    'satuan' => $produk['satuan'],
                    'harga_modal' => round($harga_modal, 2),
                    'harga_jual' => round($harga_jual, 2),
                    'harga_jual_asli' => round($harga_jual, 2),
                    'jumlah' => $jumlah,
                    'diskon_persen' => $diskon_persen_item,
                    'diskon_nominal' => round($diskon_nominal_total, 2), // Fixed: Include diskon_nominal
                    'harga_setelah_diskon' => round($harga_setelah_diskon, 2),
                    'subtotal' => round($item_subtotal, 2),
                    'laba_per_item' => round($laba_per_item, 2),
                    'berat' => $produk['berat'] ? round($produk['berat'], 3) : 0,
                    'catatan_item' => $faker->optional(0.5)->sentence, // 50% chance
                    'is_promo' => $is_promo,
                    'jenis_promo' => $jenis_promo,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert PenjualanProduk records in bulk
            DB::table('penjualan_produks')->insert($penjualan_produks);

            // Calculate totals
            $diskon_nominal = round(($subtotal * $diskon_persen) / 100, 2);
            $subtotal_setelah_diskon = $subtotal - $diskon_nominal;
            $pajak_nominal = round(($subtotal_setelah_diskon * $pajak_persen) / 100, 2);
            $total_akhir = $subtotal_setelah_diskon + $pajak_nominal + $biaya_pengiriman;

            // Determine jumlah_bayar and status_pembayaran
            $status_pembayaran_choice = $faker->randomElement($status_pembayaran);
            if ($status_pembayaran_choice === 'lunas') {
                $jumlah_bayar = round($faker->randomFloat(2, $total_akhir, $total_akhir + 50000), 2);
            } elseif ($status_pembayaran_choice === 'belum_lunas') {
                $jumlah_bayar = 0;
            } else { // sebagian
                $jumlah_bayar = round($faker->randomFloat(2, 0.01, $total_akhir - 0.01), 2);
            }
            $kembalian = round($jumlah_bayar - $total_akhir, 2);

            // Update Penjualan record
            $penjualan->update([
                'subtotal' => round($subtotal, 2),
                'diskon_nominal' => $diskon_nominal,
                'pajak_nominal' => $pajak_nominal,
                'total_akhir' => $total_akhir,
                'jumlah_bayar' => $jumlah_bayar,
                'kembalian' => $kembalian,
                'status_pembayaran' => $status_pembayaran_choice,
                'updated_at' => now(),
            ]);
        }
    }
}