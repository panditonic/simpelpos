<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanProduk extends Model
{
    use HasFactory;

    protected $table = 'penjualan_produks';

    protected $fillable = [
        'penjualan_id',
        'barang_id',
        'kode_sku',
        'nama',
        'satuan',
        'harga_modal',
        'harga_jual',
        'harga_jual_asli',
        'jumlah',
        'diskon_persen',
        'diskon_nominal',
        'harga_setelah_diskon',
        'subtotal',
        'laba_per_item',
        'berat',
        'catatan_item',
        // 'is_promo',
        // 'jenis_promo',
    ];

    protected $guarded = [];

    protected $attributes = [
        'is_promo' => false,
    ];

    protected $casts = [
        'harga_modal' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'harga_jual_asli' => 'decimal:2',
        'jumlah' => 'decimal:3',
        'diskon_persen' => 'decimal:2',
        'diskon_nominal' => 'decimal:2',
        'harga_setelah_diskon' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'laba_per_item' => 'decimal:2',
        'berat' => 'decimal:2',
        // 'is_promo' => 'boolean',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'barang_id');
    }
}
