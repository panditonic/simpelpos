<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel merek.
     */
    public function up(): void
    {
        Schema::create('mereks', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique(); // Nama merek, harus unik
            $table->string('slug')->unique()->nullable(); // Slug untuk URL
            $table->text('deskripsi')->nullable(); // Deskripsi merek, opsional
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Batalkan migrasi dengan menghapus tabel merek.
     */
    public function down(): void
    {
        Schema::dropIfExists('mereks');
    }
};