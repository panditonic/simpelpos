<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->double('subtotal', 15, 2)->default(0);
            $table->double('diskon_persen', 5, 2)->default(0);
            $table->double('diskon_nominal', 15, 2)->default(0);
            $table->double('pajak_persen', 5, 2)->default(0);
            $table->double('pajak_nominal', 15, 2)->default(0);
            $table->double('biaya_pengiriman', 15, 2)->default(0);
            $table->double('total_akhir', 15, 2)->default(0);
            $table->enum('metode_pembayaran', ['tunai', 'transfer', 'kartu_kredit', 'kartu_debit', 'e_wallet'])->default('tunai');
            $table->double('jumlah_bayar', 15, 2)->default(0);
            $table->double('kembalian', 15, 2)->default(0);
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
            $table->double('harga_modal', 15, 2)->nullable(); // Dari daftar, untuk perhitungan laba
            $table->double('harga_jual', 15, 2); // Dari daftar, harga jual saat transaksi
            $table->double('harga_jual_asli', 15, 2); // Harga sebelum diskon
            $table->double('jumlah', 10, 3); // Jumlah produk, mendukung desimal
            $table->double('diskon_persen', 5, 2)->default(0); // Diskon per item
            $table->double('diskon_nominal', 15, 2)->default(0); // Diskon nominal per item
            $table->double('harga_setelah_diskon', 15, 2); // Harga setelah diskon
            $table->double('subtotal', 15, 2); // jumlah x harga_setelah_diskon
            $table->double('laba_per_item', 15, 2)->nullable(); // (harga_setelah_diskon - harga_modal) x jumlah
            $table->double('berat', 8, 2)->nullable(); // Dari daftar, untuk ke Elder logistik
            $table->text('catatan_item')->nullable(); // Catatan opsional per item
            $table->boolean('is_promo')->default(false); // Status promo
            $table->string('jenis_promo', 50)->nullable(); // Jenis promo
            $table->timestamps();

            // Indexes
            $table->index(['penjualan_id']);
            $table->index(['barang_id']);
            $table->index(['kode_sku']);
        });

        // Create BEFORE INSERT trigger
        DB::unprepared("
            CREATE TRIGGER `insert_status_pembayaran` 
            BEFORE INSERT ON `penjualans`
            FOR EACH ROW 
            SET NEW.status_pembayaran = CASE
                WHEN NEW.kembalian >= 0 THEN 'lunas'
                ELSE 'belum_lunas'
            END
        ");

        // Create BEFORE UPDATE trigger
        DB::unprepared("
            CREATE TRIGGER `update_status_pembayaran` 
            BEFORE UPDATE ON `penjualans`
            FOR EACH ROW 
            SET NEW.status_pembayaran = CASE
                WHEN NEW.kembalian >= 0 THEN 'lunas'
                ELSE 'belum_lunas'
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
        Schema::dropIfExists('penjualan_produks');

        // Drop the triggers
        DB::unprepared('DROP TRIGGER IF EXISTS `insert_status_pembayaran`');
        DB::unprepared('DROP TRIGGER IF EXISTS `update_status_pembayaran`');
    }
};