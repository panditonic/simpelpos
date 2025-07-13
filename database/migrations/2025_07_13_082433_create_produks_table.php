<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel produk.
     */
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id(); // ID unik untuk produk
            $table->string('nama')->unique(); // Nama produk, harus unik
            $table->string('slug')->unique()->nullable(); // Slug untuk URL, opsional
            $table->text('deskripsi')->nullable(); // Deskripsi produk, opsional
            $table->decimal('harga_jual', 10, 2); // Harga jual produk
            $table->decimal('harga_modal', 10, 2)->nullable(); // Harga modal, opsional
            $table->integer('jumlah_stok')->default(0); // Jumlah stok produk
            $table->string('kode_sku')->unique()->nullable(); // Kode SKU, unik, opsional
            $table->string('kode_barcode')->unique()->nullable(); // Kode barcode, unik, opsional
            // $table->foreignId('id_kategori')->nullable()->constrained('kategoris', 'id')->onDelete('set null'); // ID kategori, terkait dengan tabel kategori
            $table->foreignId('id_kategori'); // ID kategori, terkait dengan tabel kategori
            // $table->foreignId('id_merek')->nullable()->constrained('mereks', 'id')->onDelete('set null'); // ID merek, terkait dengan tabel merek
            $table->foreignId('id_merek'); // ID merek, terkait dengan tabel merek
            $table->string('satuan')->nullable(); // Satuan produk (misal: pcs, kg), opsional
            $table->decimal('berat', 8, 2)->nullable(); // Berat produk (misal: 1.50 kg), opsional
            $table->decimal('panjang', 8, 2)->nullable(); // Panjang produk (misal: 10.00 cm), opsional
            $table->decimal('lebar', 8, 2)->nullable(); // Lebar produk, opsional
            $table->decimal('tinggi', 8, 2)->nullable(); // Tinggi produk, opsional
            $table->boolean('aktif')->default(true); // Status aktif/tidak aktif produk
            $table->integer('stok_minimum')->default(0); // Jumlah stok minimum untuk peringatan
            $table->string('gambar')->nullable(); // Path atau URL gambar produk, opsional
            $table->timestamps(); // Kolom waktu_dibuat dan waktu_diperbarui
            $table->softDeletes(); // Kolom waktu_dihapus untuk soft delete
        });
    }

    /**
     * Batalkan migrasi dengan menghapus tabel produk.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};