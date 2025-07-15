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
        // penjualans migration
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_penjualan')->unique();
            $table->date('tanggal_penjualan');
            $table->time('waktu_penjualan');
            $table->foreignId('pelanggan_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nama_pelanggan')->nullable();
            $table->string('telepon_pelanggan')->nullable();
            $table->text('alamat_pelanggan')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('diskon_persen', 5, 2);
            $table->decimal('diskon_nominal', 15, 2);
            $table->decimal('pajak_persen', 5, 2);
            $table->decimal('pajak_nominal', 15, 2);
            $table->decimal('biaya_pengiriman', 15, 2);
            $table->decimal('total_akhir', 15, 2);
            $table->string('metode_pembayaran');
            $table->decimal('jumlah_bayar', 15, 2);
            $table->decimal('kembalian', 15, 2);
            $table->string('status_pembayaran');
            $table->string('status_pengiriman');
            $table->text('catatan')->nullable();
            $table->string('referensi_pembayaran')->nullable();
            $table->timestamps();
        });

        // penjualan_produks migration
        Schema::create('penjualan_produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_id')->constrained()->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('produks')->onDelete('cascade');
            $table->string('kode_sku');
            $table->string('nama');
            $table->string('satuan');
            $table->decimal('harga_modal', 15, 2)->nullable();
            $table->decimal('harga_jual', 15, 2);
            $table->decimal('harga_jual_asli', 15, 2);
            $table->decimal('jumlah', 10, 3);
            $table->decimal('diskon_persen', 5, 2);
            $table->decimal('diskon_nominal', 15, 2);
            $table->decimal('harga_setelah_diskon', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->decimal('laba_per_item', 15, 2);
            $table->decimal('berat', 10, 3)->nullable();
            $table->text('catatan_item')->nullable();
            $table->boolean('is_promo')->default(false);
            $table->string('jenis_promo')->nullable();
            $table->timestamps();
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
