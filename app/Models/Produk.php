<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks'; // Adjust if your table name is different
    protected $fillable = [
        'nama', 'slug', 'deskripsi', 'harga_jual', 'harga_modal', 'jumlah_stok',
        'kode_sku', 'kode_barcode', 'id_kategori', 'id_merek', 'satuan', 'berat',
        'panjang', 'lebar', 'tinggi', 'aktif', 'stok_minimum', 'gambar',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function merek()
    {
        return $this->belongsTo(Merek::class, 'id_merek');
    }
}
