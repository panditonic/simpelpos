<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Kategori;
use App\Models\Merek;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nama = $this->faker->unique()->words(2, true); // Menghasilkan nama produk dari dua kata

        return [
            'nama' => $nama,
            'slug' => Str::slug($nama),
            'deskripsi' => $this->faker->sentence(10), // Kalimat acak 10 kata
            'harga_jual' => $this->faker->randomFloat(2, 10000, 1000000), // Harga jual antara 10.000 dan 1.000.000
            'harga_modal' => $this->faker->randomFloat(2, 5000, 500000), // Harga modal lebih rendah dari harga jual
            'jumlah_stok' => $this->faker->numberBetween(0, 100), // Stok acak antara 0 dan 100
            'kode_sku' => $this->faker->unique()->bothify('SKU-####'), // Kode SKU unik (misal: SKU-1234)
            'kode_barcode' => $this->faker->unique()->ean13(), // Kode barcode EAN-13
            'id_kategori' => Kategori::inRandomOrder()->first()->id, // Menghubungkan dengan kategori acak
            'id_merek' => Merek::inRandomOrder()->first()->id, // Menghubungkan dengan merek acak
            'satuan' => $this->faker->randomElement(['pcs', 'kg', 'liter', 'box']), // Satuan acak
            'berat' => $this->faker->randomFloat(2, 0.1, 10), // Berat acak antara 0.1 dan 10 kg
            'panjang' => $this->faker->randomFloat(2, 5, 100), // Panjang acak antara 5 dan 100 cm
            'lebar' => $this->faker->randomFloat(2, 5, 100), // Lebar acak antara 5 dan 100 cm
            'tinggi' => $this->faker->randomFloat(2, 5, 100), // Tinggi acak antara 5 dan 100 cm
            'aktif' => $this->faker->boolean(90), // 90% kemungkinan aktif
            'stok_minimum' => $this->faker->numberBetween(0, 20), // Stok minimum acak
            'gambar' => $this->faker->imageUrl(640, 480, 'products', true), // URL gambar dummy
            'created_at' => $this->faker->dateTimeThisYear(), // Waktu pembuatan acak dalam tahun ini
            'updated_at' => $this->faker->dateTimeThisYear(), // Waktu pembaruan acak
        ];
    }
}