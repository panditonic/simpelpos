<?php

namespace Database\Seeders;

use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks to allow truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('penjualans')->truncate();
        DB::table('penjualan_produks')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create('id_ID');
        $metode_pembayaran = ['tunai', 'transfer', 'kartu_kredit', 'kartu_debit', 'e_wallet'];
        $status_pengiriman = ['belum_dikirim', 'sedang_dikirim', 'sudah_dikirim'];

        // Fetch IDs from related tables
        $user_ids = DB::table('users')->pluck('id')->toArray();
        $pelanggan_ids = DB::table('pelanggans')->pluck('id')->toArray();
        $produks = Produk::all(['id', 'nama', 'kode_sku', 'harga_jual', 'harga_modal', 'satuan', 'berat'])->toArray();

        // Check if required data exists
        if (empty($user_ids) || empty($pelanggan_ids) || empty($produks)) {
            throw new \Exception('Users, pelanggans, or produks table is empty. Please seed those tables first.');
        }

        // Generate 100 sales records
        for ($i = 0; $i < 100; $i++) {
            $subtotal = 0;
            $diskon_persen = $faker->randomFloat(2, 0, 20);
            $pajak_persen = $faker->randomFloat(2, 0, 11);
            $biaya_pengiriman = $faker->randomFloat(2, 0, 50000);

            // Generate unique kode_penjualan
            $kode_penjualan = 'SALE-' . str_pad($i + 1, 6, '0', STR_PAD_LEFT);

            // Insert penjualan record
            $penjualan_id = DB::table('penjualans')->insertGetId([
                'kode_penjualan' => $kode_penjualan,
                'tanggal_penjualan' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'waktu_penjualan' => $faker->time(),
                'pelanggan_id' => $faker->randomElement($pelanggan_ids),
                'nama_pelanggan' => $faker->name,
                'telepon_pelanggan' => $faker->phoneNumber,
                'alamat_pelanggan' => $faker->address,
                'user_id' => $faker->randomElement($user_ids),
                'subtotal' => 0, // Will be updated after products
                'diskon_persen' => $diskon_persen,
                'diskon_nominal' => 0, // Will be calculated
                'pajak_persen' => $pajak_persen,
                'pajak_nominal' => 0, // Will be calculated
                'biaya_pengiriman' => $biaya_pengiriman,
                'total_akhir' => 0, // Will be calculated
                'metode_pembayaran' => $faker->randomElement($metode_pembayaran),
                'jumlah_bayar' => 0, // Will be calculated
                'kembalian' => 0, // Will be calculated
                // 'status_pembayaran' is set by trigger based on kembalian
                'status_pengiriman' => $faker->randomElement($status_pengiriman),
                'catatan' => $faker->sentence,
                'referensi_pembayaran' => $faker->bothify('REF-#####'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Generate 10 products for each sale
            for ($j = 0; $j < 10; $j++) {
                // Randomly select a product
                $produk = $faker->randomElement($produks);

                // Product data from Produk model
                $harga_jual = $produk['harga_jual'];
                $harga_modal = $produk['harga_modal'];
                $nama = $produk['nama'];
                $kode_sku = $produk['kode_sku'];
                $satuan = $produk['satuan'];
                $berat = $produk['berat'];

                $jumlah = $faker->randomFloat(3, 1, 100);
                $diskon_persen_item = $faker->randomFloat(2, 0, 30);
                $diskon_nominal = ($harga_jual * $jumlah * $diskon_persen_item) / 100;
                $harga_setelah_diskon = $harga_jual - ($diskon_nominal / $jumlah);
                $item_subtotal = $harga_setelah_diskon * $jumlah;
                $laba_per_item = ($harga_setelah_diskon - $harga_modal) * $jumlah;

                $subtotal += $item_subtotal;

                DB::table('penjualan_produks')->insert([
                    'penjualan_id' => $penjualan_id,
                    'barang_id' => $produk['id'],
                    'kode_sku' => $kode_sku,
                    'nama' => $nama,
                    'satuan' => $satuan,
                    'harga_modal' => $harga_modal,
                    'harga_jual' => $harga_jual,
                    'harga_jual_asli' => $harga_jual,
                    'jumlah' => $jumlah,
                    'diskon_persen' => $diskon_persen_item,
                    'diskon_nominal' => $diskon_nominal,
                    'harga_setelah_diskon' => $harga_setelah_diskon,
                    'subtotal' => $item_subtotal,
                    'laba_per_item' => $laba_per_item,
                    'berat' => $berat,
                    'catatan_item' => $faker->sentence,
                    'is_promo' => $faker->boolean(20),
                    'jenis_promo' => $faker->randomElement(['B1G1', 'Discount', 'Bundle']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Update penjualan calculations
            $diskon_nominal = ($subtotal * $diskon_persen) / 100;
            $pajak_nominal = ($subtotal * $pajak_persen) / 100;
            $total_akhir = $subtotal - $diskon_nominal + $pajak_nominal + $biaya_pengiriman;
            $jumlah_bayar = $faker->randomFloat(2, $total_akhir - 50000, $total_akhir + 100000); // Allow negative kembalian
            $kembalian = $jumlah_bayar - $total_akhir;

            DB::table('penjualans')->where('id', $penjualan_id)->update([
                'subtotal' => $subtotal,
                'diskon_nominal' => $diskon_nominal,
                'pajak_nominal' => $pajak_nominal,
                'total_akhir' => $total_akhir,
                'jumlah_bayar' => $jumlah_bayar,
                'kembalian' => $kembalian,
                'updated_at' => now(),
            ]);
        }
    }
}