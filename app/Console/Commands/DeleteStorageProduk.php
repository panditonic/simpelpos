<?php

namespace App\Console\Commands;

use App\Models\Produk;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteStorageProduk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-storage-produk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo "delete storage produk";

        $produk = Produk::inRandomOrder()->first();
        if (file_exists("public/" . $produk->gambar)) {
            echo "\nfile tersedia";
            unlink("public/" . $produk->gambar);
        } else {
            echo "\nfile tidak tersedia {$produk->gambar}";
        }
    }
}
