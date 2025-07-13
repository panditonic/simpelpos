<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel kategori.
     */
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique(); // Nama kategori, harus unik
            $table->string('slug')->unique()->nullable(); // Slug untuk URL
            $table->text('deskripsi')->nullable(); // Deskripsi kategori, opsional
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Batalkan migrasi dengan menghapus tabel kategori.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};