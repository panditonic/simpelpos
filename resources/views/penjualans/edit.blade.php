@extends('dasbor')

@push('styles')
<style>
    .invoice-box {
        margin: auto;
        padding: 15px; /* Reduced padding for a more compact container */
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .invoice-header {
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 10px; /* Reduced padding */
        margin-bottom: 15px; /* Reduced margin */
    }

    .invoice-header h2 {
        font-size: 1.8rem; /* Slightly smaller header */
        color: #1a73e8;
        margin: 0;
    }

    .invoice-details,
    .customer-info,
    .payment-info {
        padding: 8px; /* Reduced padding */
    }

    .invoice-details h5,
    .customer-info h5,
    .payment-info h5 {
        font-size: 1rem; /* Smaller section headers */
        color: #333;
        margin-bottom: 10px; /* Reduced margin */
    }

    /* Smaller form inputs */
    .form-container .form-control,
    .form-container .form-select {
        height: 28px; /* Smaller input height */
        padding: 3px 6px; /* Reduced padding */
        font-size: 0.8rem; /* Smaller font size */
        line-height: 1.2; /* Tighter line height */
    }

    .form-container .form-label {
        font-size: 0.85rem; /* Smaller label font size */
        margin-bottom: 3px; /* Reduced margin */
    }

    .form-container .input-group-text {
        padding: 3px 6px;
        font-size: 0.8rem;
    }

    .form-container textarea.form-control {
        min-height: 60px; /* Reduced textarea height */
        font-size: 0.8rem;
    }

    .table-container {
        overflow-x: auto;
        width: 100%;
        -webkit-overflow-scrolling: touch;
    }

    .invoice-box table {
        width: 100%;
        min-width: 1000px;
        border-collapse: collapse;
        margin-top: 15px; /* Reduced margin */
    }

    .invoice-box table th,
    .invoice-box table td {
        padding: 6px;
        vertical-align: middle;
        text-align: left;
        font-size: 0.85rem;
        line-height: 1.2;
        white-space: nowrap;
    }

    .invoice-box table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }

    .invoice-box table td {
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.total td {
        font-weight: bold;
        border-top: 2px solid #dee2e6;
    }

    .btn-add-product {
        background-color: #6c757d;
        border-color: #6c757d;
        font-size: 0.85rem; /* Smaller button font */
        padding: 5px 10px; /* Smaller button padding */
    }

    .btn-add-product:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .btn-primary,
    .btn-secondary {
        font-size: 0.85rem; /* Smaller button font */
        padding: 5px 10px; /* Smaller button padding */
    }

    /* Table input styling */
    .invoice-box table .form-control,
    .invoice-box table .form-select {
        height: 28px;
        padding: 3px;
        font-size: 0.8rem;
        width: 100%;
        box-sizing: border-box;
    }

    .invoice-box table .input-group-text {
        padding: 3px 6px;
        font-size: 0.8rem;
    }

    .invoice-box table .form-check-input {
        margin-top: 0.2rem;
    }

    /* Column width optimization */
    .invoice-box table th:nth-child(1),
    .invoice-box table td:nth-child(1) { width: 12%; } /* Produk */
    .invoice-box table th:nth-child(2),
    .invoice-box table td:nth-child(2) { width: 8%; } /* Kode SKU */
    .invoice-box table th:nth-child(3),
    .invoice-box table td:nth-child(3) { width: 6%; } /* Satuan */
    .invoice-box table th:nth-child(4),
    .invoice-box table td:nth-child(4) { width: 7%; } /* Jumlah */
    .invoice-box table th:nth-child(5),
    .invoice-box table td:nth-child(5) { width: 7%; } /* Harga Modal */
    .invoice-box table th:nth-child(6),
    .invoice-box table td:nth-child(6) { width: 7%; } /* Harga Jual */
    .invoice-box table th:nth-child(7),
    .invoice-box table td:nth-child(7) { width: 7%; } /* Diskon (%) */
    .invoice-box table th:nth-child(8),
    .invoice-box table td:nth-child(8) { width: 7%; } /* Harga Setelah Diskon */
    .invoice-box table th:nth-child(9),
    .invoice-box table td:nth-child(9) { width: 7%; } /* Subtotal */
    .invoice-box table th:nth-child(10),
    .invoice-box table td:nth-child(10) { width: 7%; } /* Berat */
    .invoice-box table th:nth-child(11),
    .invoice-box table td:nth-child(11) { width: 7%; } /* Catatan Item */
    .invoice-box table th:nth-child(12),
    .invoice-box table td:nth-child(12) { width: 7%; } /* Laba Per Item */
    .invoice-box table th:nth-child(13),
    .invoice-box table td:nth-child(13) { width: 7%; } /* Aksi */

    @media (max-width: 768px) {
        .invoice-box {
            padding: 10px; /* Further reduced padding */
        }

        .invoice-header {
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .invoice-header h2 {
            font-size: 1.6rem;
        }

        .invoice-details,
        .customer-info,
        .payment-info {
            padding: 6px;
            margin-bottom: 10px;
        }

        .invoice-details h5,
        .customer-info h5,
        .payment-info h5 {
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .form-container .form-control,
        .form-container .form-select {
            height: 26px;
            padding: 2px 5px;
            font-size: 0.75rem;
        }

        .form-container .form-label {
            font-size: 0.8rem;
            margin-bottom: 2px;
        }

        .form-container .input-group-text {
            padding: 2px 5px;
            font-size: 0.75rem;
        }

        .form-container textarea.form-control {
            min-height: 50px;
        }

        .invoice-box table th,
        .invoice-box table td {
            font-size: 0.75rem;
            padding: 4px;
        }

        .invoice-box table .form-control,
        .invoice-box table .form-select {
            font-size: 0.75rem;
            height: 26px;
            padding: 2px;
        }

        .invoice-box table .input-group-text {
            font-size: 0.75rem;
            padding: 2px 5px;
        }

        .btn-add-product,
        .btn-primary,
        .btn-secondary {
            font-size: 0.8rem;
            padding: 4px 8px;
        }
    }

    @media (max-width: 576px) {
        .invoice-box {
            padding: 8px;
        }

        .invoice-header {
            padding-bottom: 6px;
            margin-bottom: 10px;
        }

        .invoice-header h2 {
            font-size: 1.4rem;
        }

        .invoice-details,
        .customer-info,
        .payment-info {
            padding: 5px;
        }

        .invoice-details h5,
        .customer-info h5,
        .payment-info h5 {
            font-size: 0.85rem;
            margin-bottom: 6px;
        }

        .form-container .form-control,
        .form-container .form-select {
            height: 24px;
            padding: 2px 4px;
            font-size: 0.7rem;
        }

        .form-container .form-label {
            font-size: 0.75rem;
            margin-bottom: 2px;
        }

        .form-container .input-group-text {
            font-size: 0.7rem;
            padding: 2px 4px;
        }

        .form-container textarea.form-control {
            min-height: 40px;
        }

        .invoice-box table th,
        .invoice-box table td {
            font-size: 0.7rem;
            padding: 3px;
        }

        .invoice-box table .form-control,
        .invoice-box table .form-select {
            font-size: 0.7rem;
            height: 24px;
            padding: 2px;
        }

        .invoice-box table .input-group-text {
            font-size: 0.7rem;
            padding: 2px 4px;
        }

        .btn-add-product,
        .btn-primary,
        .btn-secondary {
            font-size: 0.75rem;
            padding: 3px 6px;
        }
    }
</style>
@endpush

@section('content')
@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="container-fluid">
    <div class="invoice-box">
        <form action="{{ route('penjualans.update', $penjualan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row invoice-header">
                <div class="col-12">
                    <h2>Edit Invoice Penjualan</h2>
                </div>
            </div>

            <div class="container-fluid">
                <div class="form-container">
                    <div class="row g-4">
                        <!-- Column 1: Detail Invoice -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="h-100 d-flex flex-column">
                                <h5 class="section-header">Detail Invoice</h5>
                                <div class="mb-2">
                                    <label for="kode_penjualan" class="form-label">Nomor</label>
                                    <input type="text" name="kode_penjualan" id="kode_penjualan" class="form-control" value="{{ old('kode_penjualan', $penjualan->kode_penjualan) }}" placeholder="Masukkan nomor invoice">
                                </div>
                                <div class="mb-2">
                                    <label for="tanggal_penjualan" class="form-label">Tanggal</label>
                                    <input type="date" name="tanggal_penjualan" id="tanggal_penjualan" class="form-control" value="{{ old('tanggal_penjualan', $penjualan->tanggal_penjualan) }}">
                                </div>
                                <div class="mb-2">
                                    <label for="waktu_penjualan" class="form-label">Waktu</label>
                                    <input type="time" name="waktu_penjualan" id="waktu_penjualan" class="form-control" value="{{ old('waktu_penjualan', $penjualan->waktu_penjualan) }}">
                                </div>
                                <div class="mb-2 flex-grow-1">
                                    <label for="catatan" class="form-label">Catatan</label>
                                    <textarea name="catatan" id="catatan" class="form-control h-100" rows="3" placeholder="Catatan tambahan...">{{ old('catatan', $penjualan->catatan) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Column 2: Informasi Pelanggan -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="h-100 d-flex flex-column">
                                <h5 class="section-header">Informasi Pelanggan</h5>
                                <div class="mb-2">
                                    <label for="pelanggan_id" class="form-label">Pelanggan</label>
                                    <select name="pelanggan_id" id="pelanggan_id" class="form-select">
                                        <option value="">Tanpa Pelanggan</option>
                                        @foreach ($pelanggans as $pelanggan)
                                        <option value="{{ $pelanggan->id }}"
                                            {{ old('pelanggan_id', $penjualan->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}
                                            data-nama="{{ $pelanggan->nama }}"
                                            data-telepon="{{ $pelanggan->telepon }}"
                                            data-alamat="{{ $pelanggan->alamat }}">{{ $pelanggan->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                                    <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" value="{{ old('nama_pelanggan', $penjualan->nama_pelanggan) }}" placeholder="Nama lengkap pelanggan">
                                </div>
                                <div class="mb-2">
                                    <label for="telepon_pelanggan" class="form-label">Telepon Pelanggan</label>
                                    <input type="text" name="telepon_pelanggan" id="telepon_pelanggan" class="form-control" value="{{ old('telepon_pelanggan', $penjualan->telepon_pelanggan) }}" placeholder="Nomor telepon">
                                </div>
                                <div class="mb-2 flex-grow-1">
                                    <label for="alamat_pelanggan" class="form-label">Alamat Pelanggan</label>
                                    <textarea name="alamat_pelanggan" id="alamat_pelanggan" class="form-control h-100" rows="3" placeholder="Alamat lengkap pelanggan...">{{ old('alamat_pelanggan', $penjualan->alamat_pelanggan) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Column 3: Detail Pembayaran & Status -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="h-100 d-flex flex-column">
                                <h5 class="section-header">Detail Pembayaran</h5>
                                <div class="mb-2">
                                    <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                                        <option value="tunai" {{ old('metode_pembayaran', $penjualan->metode_pembayaran) == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                        <option value="transfer" {{ old('metode_pembayaran', $penjualan->metode_pembayaran) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                        <option value="kartu_kredit" {{ old('metode_pembayaran', $penjualan->metode_pembayaran) == 'kartu_kredit' ? 'selected' : '' }}>Kartu Kredit</option>
                                        <option value="kartu_debit" {{ old('metode_pembayaran', $penjualan->metode_pembayaran) == 'kartu_debit' ? 'selected' : '' }}>Kartu Debit</option>
                                        <option value="e_wallet" {{ old('metode_pembayaran', $penjualan->metode_pembayaran) == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="referensi_pembayaran" class="form-label">Referensi Pembayaran</label>
                                    <input type="text" name="referensi_pembayaran" id="referensi_pembayaran" class="form-control" value="{{ old('referensi_pembayaran', $penjualan->referensi_pembayaran) }}" placeholder="Nomor referensi">
                                </div>
                                <div class="mb-2">
                                    <label for="status_pengiriman" class="form-label">Status Pengiriman</label>
                                    <select name="status_pengiriman" id="status_pengiriman" class="form-select" required>
                                        <option value="belum_dikirim" {{ old('status_pengiriman', $penjualan->status_pengiriman) == 'belum_dikirim' ? 'selected' : '' }}>Belum Dikirim</option>
                                        <option value="sedang_dikirim" {{ old('status_pengiriman', $penjualan->status_pengiriman) == 'sedang_dikirim' ? 'selected' : '' }}>Sedang Dikirim</option>
                                        <option value="sudah_dikirim" {{ old('status_pengiriman', $penjualan->status_pengiriman) == 'sudah_dikirim' ? 'selected' : '' }}>Sudah Dikirim</option>
                                    </select>
                                </div>
                                <div class="mb-2 flex-grow-1">
                                    <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                                    <select name="status_pembayaran" id="status_pembayaran" class="form-select" required>
                                        <option value="lunas" {{ old('status_pembayaran', $penjualan->status_pembayaran) == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                        <option value="belum_lunas" {{ old('status_pembayaran', $penjualan->status_pembayaran) == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                        <option value="sebagian" {{ old('status_pembayaran', $penjualan->status_pembayaran) == 'sebagian' ? 'selected' : '' }}>Sebagian</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Column 4: Perhitungan Pembayaran -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="h-100 d-flex flex-column">
                                <h5 class="section-header">Perhitungan Pembayaran</h5>
                                <div class="mb-2">
                                    <label for="jumlah_bayar" class="form-label">Jumlah Bayar</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" min="0" step="0.01" class="form-control" name="jumlah_bayar" id="jumlah_bayar" value="{{ old('jumlah_bayar', $penjualan->jumlah_bayar) }}" oninput="updateKembalian()" placeholder="0">
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="diskon_persen" class="form-label">Diskon (%)</label>
                                    <input type="number" min="0" max="100" step="0.01" class="form-control" name="diskon_persen" id="diskon_persen" value="{{ old('diskon_persen', $penjualan->diskon_persen) }}" oninput="updateTotal()" placeholder="0">
                                </div>
                                <div class="mb-2">
                                    <label for="pajak_persen" class="form-label">Pajak (%)</label>
                                    <input type="number" min="0" max="100" step="0.01" class="form-control" name="pajak_persen" id="pajak_persen" value="{{ old('pajak_persen', $penjualan->pajak_persen) }}" oninput="updateTotal()" placeholder="0">
                                </div>
                                <div class="mb-2">
                                    <label for="biaya_pengiriman" class="form-label">Biaya Pengiriman</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" min="0" step="0.01" class="form-control" name="biaya_pengiriman" id="biaya_pengiriman" value="{{ old('biaya_pengiriman', $penjualan->biaya_pengiriman) }}" oninput="updateTotal()" placeholder="0">
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="total_akhir" class="form-label">Total Akhir</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control readonly-field" id="total_akhir" value="{{ old('total_akhir', number_format($penjualan->total_akhir, 2, ',', '.')) }}" readonly>
                                    </div>
                                </div>
                                <div class="mb-2 flex-grow-1">
                                    <label for="kembalian" class="form-label">Kembalian</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control readonly-field" id="kembalian" value="{{ old('kembalian', number_format($penjualan->kembalian, 2, ',', '.')) }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Kode SKU</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                            <th>Harga Modal</th>
                            <th>Harga Jual</th>
                            <th>Diskon (%)</th>
                            <th>Harga Setelah Diskon</th>
                            <th>Subtotal</th>
                            <th>Berat</th>
                            <th>Catatan Item</th>
                            <th>Laba Per Item</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="produk-list">
                        @foreach ($penjualan->produks as $index => $item)
                        <tr class="produk-item">
                            <td>
                                <select name="produks[{{ $index }}][barang_id]" class="form-select produk-select" required onchange="updateHarga(this)">
                                    <option value="">Pilih Produk</option>
                                    @foreach ($produks as $produk)
                                    <option value="{{ $produk->id }}"
                                        data-harga="{{ $produk->harga_jual }}"
                                        data-harga-modal="{{ $produk->harga_modal }}"
                                        data-kode-sku="{{ $produk->kode_sku }}"
                                        data-satuan="{{ $produk->satuan }}"
                                        data-berat="{{ $produk->berat }}"
                                        {{ old('produks.' . $index . '.barang_id', $item->barang_id) == $produk->id ? 'selected' : '' }}>{{ $produk->nama }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="produks[{{ $index }}][kode_sku]" class="form-control kode-sku" value="{{ old('produks.' . $index . '.kode_sku', $item->kode_sku) }}" readonly>
                            </td>
                            <td>
                                <input type="text" name="produks[{{ $index }}][satuan]" class="form-control satuan" value="{{ old('produks.' . $index . '.satuan', $item->satuan) }}" readonly>
                            </td>
                            <td>
                                <input type="number" name="produks[{{ $index }}][jumlah]" class="form-control jumlah" value="{{ old('produks.' . $index . '.jumlah', $item->jumlah) }}" step="0.001" required oninput="updateSubtotal(this)">
                            </td>
                            <td>
                                <input type="text" name="produks[{{ $index }}][harga_modal]" class="form-control harga-modal" value="{{ old('produks.' . $index . '.harga_modal', $item->harga_modal) }}" readonly>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="number" name="produks[{{ $index }}][harga_jual]" class="form-control harga" value="{{ old('produks.' . $index . '.harga_jual', $item->harga_jual) }}" step="0.01" required oninput="updateSubtotal(this)">
                                    <input type="hidden" name="produks[{{ $index }}][harga_jual_asli]" class="harga-jual-asli" value="{{ old('produks.' . $index . '.harga_jual_asli', $item->harga_jual_asli) }}">
                                </div>
                            </td>
                            <td>
                                <input type="number" name="produks[{{ $index }}][diskon_persen]" class="form-control diskon-persen" value="{{ old('produks.' . $index . '.diskon_persen', $item->diskon_persen) }}" min="0" max="100" step="0.01" oninput="updateSubtotal(this)">
                            </td>
                            <td>
                                <input type="text" name="produks[{{ $index }}][harga_setelah_diskon]" class="form-control harga-setelah-diskon" value="{{ old('produks.' . $index . '.harga_setelah_diskon', number_format($item->harga_setelah_diskon, 2, ',', '.')) }}" readonly>
                            </td>
                            <td>
                                <span class="subtotal">Rp {{ old('produks.' . $index . '.subtotal', number_format($item->subtotal, 2, ',', '.')) }}</span>
                                <input type="hidden" name="produks[{{ $index }}][subtotal]" class="subtotal-input" value="{{ old('produks.' . $index . '.subtotal', $item->subtotal) }}">
                                <input type="hidden" name="produks[{{ $index }}][laba_per_item]" class="laba-per-item" value="{{ old('produks.' . $index . '.laba_per_item', $item->laba_per_item) }}">
                            </td>
                            <td>
                                <input type="text" name="produks[{{ $index }}][berat]" class="form-control berat" value="{{ old('produks.' . $index . '.berat', $item->berat) }}" readonly>
                            </td>
                            <td>
                                <textarea name="produks[{{ $index }}][catatan_item]" class="form-control catatan-item">{{ old('produks.' . $index . '.catatan_item', $item->catatan_item) }}</textarea>
                            </td>
                            <td>
                                <span class="laba-per-item-display">Rp {{ old('produks.' . $index . '.laba_per_item', number_format($item->laba_per_item, 2, ',', '.')) }}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeProduk(this)">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="total">
                            <td colspan="7">Subtotal:</td>
                            <td><span id="subtotal">Rp {{ number_format($penjualan->subtotal, 2, ',', '.') }}</span></td>
                            <td colspan="5"></td>
                        </tr>
                        <tr class="total">
                            <td colspan="7">Diskon Nominal:</td>
                            <td><span id="diskon_nominal">Rp {{ number_format($penjualan->diskon_nominal, 2, ',', '.') }}</span></td>
                            <td colspan="5"></td>
                        </tr>
                        <tr class="total">
                            <td colspan="7">Pajak Nominal:</td>
                            <td><span id="pajak_nominal">Rp {{ number_format($penjualan->pajak_nominal, 2, ',', '.') }}</span></td>
                            <td colspan="5"></td>
                        </tr>
                        <tr class="total">
                            <td colspan="7">Total Akhir:</td>
                            <td><span id="total_akhir_footer">Rp {{ number_format($penjualan->total_akhir, 2, ',', '.') }}</span></td>
                            <td colspan="5"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-2">
                <button type="button" class="btn btn-add-product" onclick="addProduk()">Tambah Produk</button>
                <button type="submit" class="btn btn-primary">Update Invoice</button>
                <a href="{{ route('penjualans.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let produkCount = "{{ count($penjualan->produks) }}";

    function formatRupiah(angka) {
        return "Rp " + parseFloat(angka).toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function parseRupiah(str) {
        return parseFloat(str.replace(/[^0-9,-]+/g, '').replace(',', '.'));
    }

    function addProduk() {
        const produkList = document.getElementById('produk-list');
        const newProduk = document.createElement('tr');
        newProduk.classList.add('produk-item');
        newProduk.innerHTML = `
            <tr class="produk-item">
                <td>
                    <select name="produks[${produkCount}][barang_id]" class="form-select produk-select" required onchange="updateHarga(this)">
                        <option value="">Pilih Produk</option>
                        @foreach ($produks as $produk)
                        <option value="{{ $produk->id }}"
                            data-harga="{{ $produk->harga_jual }}"
                            data-harga-modal="{{ $produk->harga_modal }}"
                            data-kode-sku="{{ $produk->kode_sku }}"
                            data-satuan="{{ $produk->satuan }}"
                            data-berat="{{ $produk->berat }}">{{ $produk->nama }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="produks[${produkCount}][kode_sku]" class="form-control kode-sku" readonly>
                </td>
                <td>
                    <input type="text" name="produks[${produkCount}][satuan]" class="form-control satuan" readonly>
                </td>
                <td>
                    <input type="number" name="produks[${produkCount}][jumlah]" class="form-control jumlah" value="1" step="0.001" required oninput="updateSubtotal(this)">
                </td>
                <td>
                    <input type="text" name="produks[${produkCount}][harga_modal]" class="form-control harga-modal" value="0" readonly>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" name="produks[${produkCount}][harga_jual]" class="form-control harga" value="0" step="0.01" required oninput="updateSubtotal(this)">
                        <input type="hidden" name="produks[${produkCount}][harga_jual_asli]" class="harga-jual-asli" value="0">
                    </div>
                </td>
                <td>
                    <input type="number" name="produks[${produkCount}][diskon_persen]" class="form-control diskon-persen" value="0" min="0" max="100" step="0.01" oninput="updateSubtotal(this)">
                </td>
                <td>
                    <input type="text" name="produks[${produkCount}][harga_setelah_diskon]" class="form-control harga-setelah-diskon" value="0" readonly>
                </td>
                <td>
                    <span class="subtotal">Rp 0</span>
                    <input type="hidden" name="produks[${produkCount}][subtotal]" class="subtotal-input" value="0">
                    <input type="hidden" name="produks[${produkCount}][laba_per_item]" class="laba-per-item" value="0">
                </td>
                <td>
                    <input type="text" name="produks[${produkCount}][berat]" class="form-control berat" value="0" readonly>
                </td>
                <td>
                    <textarea name="produks[${produkCount}][catatan_item]" class="form-control catatan-item"></textarea>
                </td>
                <td>
                    <span class="laba-per-item-display">Rp 0</span>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeProduk(this)">Hapus</button>
                </td>
            </tr>`;
        produkList.appendChild(newProduk);
        produkCount++;
        updateTotal();
    }

    function removeProduk(button) {
        if (document.querySelectorAll('.produk-item').length > 1) {
            button.closest('tr').remove();
            updateTotal();
        }
    }

    function updateHarga(select) {
        const row = select.closest('tr');
        const option = select.options[select.selectedIndex];
        const harga = parseFloat(option.dataset.harga) || 0;
        const hargaModal = parseFloat(option.dataset.hargaModal) || 0;
        const kodeSku = option.dataset.kodeSku || '';
        const satuan = option.dataset.satuan || '';
        const berat = parseFloat(option.dataset.berat) || 0;

        row.querySelector('.harga').value = harga.toFixed(2);
        row.querySelector('.harga-jual-asli').value = harga.toFixed(2);
        row.querySelector('.harga-modal').value = hargaModal.toFixed(2);
        row.querySelector('.kode-sku').value = kodeSku;
        row.querySelector('.satuan').value = satuan;
        row.querySelector('.berat').value = berat.toFixed(3);
        updateSubtotal(row.querySelector('.jumlah'));
    }

    function updateSubtotal(input) {
        const row = input.closest('tr');
        const jumlah = parseFloat(row.querySelector('.jumlah').value) || 0;
        const hargaJual = parseFloat(row.querySelector('.harga').value) || 0;
        const diskonPersen = parseFloat(row.querySelector('.diskon-persen').value) || 0;
        const hargaModal = parseFloat(row.querySelector('.harga-modal').value) || 0;

        const diskonNominal = (hargaJual * diskonPersen) / 100;
        const hargaSetelahDiskon = hargaJual - diskonNominal;
        const subtotal = hargaSetelahDiskon * jumlah;
        const labaPerItem = (hargaSetelahDiskon - hargaModal) * jumlah;

        row.querySelector('.harga-setelah-diskon').value = (hargaSetelahDiskon);
        row.querySelector('.subtotal').textContent = formatRupiah(subtotal);
        row.querySelector('.subtotal-input').value = subtotal.toFixed(2);
        row.querySelector('.laba-per-item').value = labaPerItem.toFixed(2);
        row.querySelector('.laba-per-item-display').textContent = formatRupiah(labaPerItem);

        updateTotal();
    }

    function updateTotal() {
        let subtotal = 0;
        document.querySelectorAll('.subtotal-input').forEach(input => {
            subtotal += parseFloat(input.value) || 0;
        });

        const diskonPersen = parseFloat(document.getElementById('diskon_persen').value) || 0;
        const pajakPersen = parseFloat(document.getElementById('pajak_persen').value) || 0;
        const biayaPengiriman = parseFloat(document.getElementById('biaya_pengiriman').value) || 0;

        const diskonNominal = (subtotal * diskonPersen) / 100;
        const pajakNominal = (subtotal * pajakPersen) / 100;
        const totalAkhir = subtotal - diskonNominal + pajakNominal + biayaPengiriman;

        document.getElementById('subtotal').textContent = formatRupiah(subtotal);
        document.getElementById('diskon_nominal').textContent = formatRupiah(diskonNominal);
        document.getElementById('pajak_nominal').textContent = formatRupiah(pajakNominal);
        document.getElementById('total_akhir').value = formatRupiah(totalAkhir);
        document.getElementById('total_akhir_footer').textContent = formatRupiah(totalAkhir);

        updateKembalian();
    }

    function updateKembalian() {
        const jumlahBayar = parseFloat(document.getElementById('jumlah_bayar').value) || 0;
        const totalAkhir = parseRupiah(document.getElementById('total_akhir').value) || 0;
        const kembalian = jumlahBayar - totalAkhir;
        document.getElementById('kembalian').value = formatRupiah(kembalian);
    }

    // Update customer info when pelanggan_id changes
    document.getElementById('pelanggan_id').addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        document.getElementById('nama_pelanggan').value = option.dataset.nama || '';
        document.getElementById('telepon_pelanggan').value = option.dataset.telepon || '';
        document.getElementById('alamat_pelanggan').value = option.dataset.alamat || '';
    });

    // Initialize subtotals and total on page load
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.produk-item').forEach(row => {
            updateSubtotal(row.querySelector('.jumlah'));
        });
        updateTotal();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush