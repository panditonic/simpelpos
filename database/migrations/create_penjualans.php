<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_penjualan', 50)->unique();
            $table->date('tanggal_penjualan');
            $table->time('waktu_penjualan');
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggans')->onDelete('set null');
            $table->string('nama_pelanggan', 100)->nullable();
            $table->string('telepon_pelanggan', 20)->nullable();
            $table->text('alamat_pelanggan')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('diskon_persen', 5, 2)->default(0);
            $table->decimal('diskon_nominal', 15, 2)->default(0);
            $table->decimal('pajak_persen', 5, 2)->default(0);
            $table->decimal('pajak_nominal', 15, 2)->default(0);
            $table->decimal('biaya_pengiriman', 15, 2)->default(0);
            $table->decimal('total_akhir', 15, 2)->default(0);
            $table->enum('metode_pembayaran', ['tunai', 'transfer', 'kartu_kredit', 'kartu_debit', 'e_wallet'])->default('tunai');
            $table->decimal('jumlah_bayar', 15, 2)->default(0);
            $table->decimal('kembalian', 15, 2)->default(0);
            $table->enum('status_pembayaran', ['lunas', 'belum_lunas', 'sebagian'])->default('lunas');
            $table->enum('status_pengiriman', ['belum_dikirim', 'sedang_dikirim', 'sudah_dikirim'])->default('belum_dikirim');
            $table->text('catatan')->nullable();
            $table->string('referensi_pembayaran', 100)->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['tanggal_penjualan']);
            $table->index(['status_pembayaran']);
            $table->index(['user_id']);
            $table->index(['pelanggan_id']);
        });

        Schema::create('penjualan_produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_id')->constrained('penjualans')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('produks')->onDelete('cascade');
            $table->string('kode_sku', 50)->nullable(); // Dari daftar, untuk snapshot kode produk
            $table->string('nama', 100); // Dari daftar, untuk snapshot nama produk
            $table->string('satuan', 20)->nullable(); // Dari daftar, untuk snapshot satuan
            $table->decimal('harga_modal', 15, 2)->nullable(); // Dari daftar, untuk perhitungan laba
            $table->decimal('harga_jual', 15, 2); // Dari daftar, harga jual saat transaksi
            $table->decimal('harga_jual_asli', 15, 2); // Harga sebelum diskon
            $table->decimal('jumlah', 10, 3); // Jumlah produk, mendukung desimal
            $table->decimal('diskon_persen', 5, 2)->default(0); // Diskon per item
            $table->decimal('diskon_nominal', 15, 2)->default(0); // Diskon nominal per item
            $table->decimal('harga_setelah_diskon', 15, 2); // Harga setelah diskon
            $table->decimal('subtotal', 15, 2); // jumlah x harga_setelah_diskon
            $table->decimal('laba_per_item', 15, 2)->nullable(); // (harga_setelah_diskon - harga_modal) x jumlah
            $table->decimal('berat', 8, 2)->nullable(); // Dari daftar, untuk ke Elder logistik
            $table->text('catatan_item')->nullable(); // Catatan opsional per item
            $table->boolean('is_promo')->default(false); // Status promo
            $table->string('jenis_promo', 50)->nullable(); // Jenis promo
            $table->timestamps();

            // Indexes
            $table->index(['penjualan_id']);
            $table->index(['barang_id']);
            $table->index(['kode_sku']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
        Schema::dropIfExists('penjualan_produks');
    }
};