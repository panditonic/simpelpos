<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Kategori::factory()->count(10)->create();
        Merek::factory()->count(10)->create();
        Produk::factory()->count(50)->create();
        Pelanggan::factory()->count(50)->create();

        // $this->call(PenjualanSeeder::class);
    }
}
