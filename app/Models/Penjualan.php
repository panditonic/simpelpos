<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';

    protected $fillable = [
        'kode_penjualan',
        'tanggal_penjualan',
        'waktu_penjualan',
        'pelanggan_id',
        'nama_pelanggan',
        'telepon_pelanggan',
        'alamat_pelanggan',
        'user_id',
        'subtotal',
        'diskon_persen',
        'diskon_nominal',
        'pajak_persen',
        'pajak_nominal',
        'biaya_pengiriman',
        'total_akhir',
        'metode_pembayaran',
        'jumlah_bayar',
        'kembalian',
        'status_pembayaran',
        'status_pengiriman',
        'catatan',
        'referensi_pembayaran',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'diskon_persen' => 'decimal:2',
        'diskon_nominal' => 'decimal:2',
        'pajak_persen' => 'decimal:2',
        'pajak_nominal' => 'decimal:2',
        'biaya_pengiriman' => 'decimal:2',
        'total_akhir' => 'decimal:2',
        'jumlah_bayar' => 'decimal:2',
        'kembalian' => 'decimal:2',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function produks()
    {
        return $this->hasMany(PenjualanProduk::class, 'penjualan_id');
    }
}