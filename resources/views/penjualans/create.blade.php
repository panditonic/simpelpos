@extends('dasbor')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .invoice-box {
        /* max-width: 900px; */
        margin: auto;
        padding: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }
    .invoice-header {
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }
    .invoice-header h2 {
        font-size: 2rem;
        color: #1a73e8;
        margin: 0;
    }
    .invoice-details, .customer-info, .payment-info {
        padding: 10px;
    }
    .invoice-details h5, .customer-info h5, .payment-info h5 {
        font-size: 1.1rem;
        color: #333;
        margin-bottom: 15px;
    }
    .invoice-box table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .invoice-box table th, .invoice-box table td {
        padding: 10px;
        vertical-align: middle;
        text-align: left;
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
    }
    .btn-add-product:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
    @media (max-width: 768px) {
        .invoice-details, .customer-info, .payment-info {
            margin-bottom: 15px;
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
        <form action="{{ route('penjualans.store') }}" method="POST">
            @csrf
            <div class="row invoice-header">
                <div class="col-12">
                    <h2>Invoice Penjualan</h2>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4 invoice-details">
                    <h5>Detail Invoice</h5>
                    <p><strong>Nomor:</strong> <span id="kode_penjualan">PJ-{{ date('Ymd') }}-XXXXXX</span></p>
                    <p><strong>Tanggal:</strong> {{ date('Y-m-d') }}</p>
                    <p><strong>Waktu:</strong> {{ date('H:i:s') }}</p>
                </div>
                <div class="col-md-4 customer-info">
                    <h5>Informasi Pelanggan</h5>
                    <div class="mb-3">
                        <label for="pelanggan_id" class="form-label">Pelanggan</label>
                        <select name="pelanggan_id" id="pelanggan_id" class="form-select">
                            <option value="">Tanpa Pelanggan</option>
                            @foreach ($pelanggans as $pelanggan)
                                <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 payment-info">
                    <h5>Detail Pembayaran</h5>
                    <div class="mb-3">
                        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                            <option value="tunai">Tunai</option>
                            <option value="transfer">Transfer</option>
                            <option value="kartu_kredit">Kartu Kredit</option>
                            <option value="kartu_debit">Kartu Debit</option>
                            <option value="e_wallet">E-Wallet</option>
                        </select>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                        <select name="status_pembayaran" id="status_pembayaran" class="form-select" required>
                            <option value="lunas">Lunas</option>
                            <option value="belum_lunas">Belum Lunas</option>
                            <option value="sebagian">Sebagian</option>
                        </select>
                    </div> -->
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="produk-list">
                    <tr class="produk-item">
                        <td>
                            <select name="produks[0][barang_id]" class="form-select produk-select" required onchange="updateHarga(this)">
                                <option value="">Pilih Produk</option>
                                @foreach ($produks as $produk)
                                    <option value="{{ $produk->id }}" data-harga="{{ $produk->harga_jual }}">{{ $produk->nama }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="produks[0][jumlah]" class="form-control jumlah" placeholder="Jumlah" step="0.001" required oninput="updateSubtotal(this)">
                        </td>
                        <td>
                            <input type="number" name="produks[0][harga_jual]" class="form-control harga" placeholder="Harga Jual" step="0.01" required oninput="updateSubtotal(this)">
                        </td>
                        <td>
                            <span class="subtotal">0.00</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeProduk(this)">Hapus</button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="total">
                        <td colspan="3">Total:</td>
                        <td><span id="total">0.00</span></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div class="mt-3">
                <button type="button" class="btn btn-add-product" onclick="addProduk()">Tambah Produk</button>
                <button type="submit" class="btn btn-primary">Simpan Invoice</button>
                <a href="{{ route('penjualans.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let produkCount = 1;

    function addProduk() {
        const produkList = document.getElementById('produk-list');
        const newProduk = document.createElement('tr');
        newProduk.classList.add('produk-item');
        newProduk.innerHTML = `
            <td>
                <select name="produks[${produkCount}][barang_id]" class="form-select produk-select" required onchange="updateHarga(this)">
                    <option value="">Pilih Produk</option>
                    @foreach ($produks as $produk)
                        <option value="{{ $produk->id }}" data-harga="{{ $produk->harga_jual }}">{{ $produk->nama }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="produks[${produkCount}][jumlah]" class="form-control jumlah" placeholder="Jumlah" step="0.001" required oninput="updateSubtotal(this)">
            </td>
            <td>
                <input type="number" name="produks[${produkCount}][harga_jual]" class="form-control harga" placeholder="Harga Jual" step="0.01" required oninput="updateSubtotal(this)">
            </td>
            <td>
                <span class="subtotal">0.00</span>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeProduk(this)">Hapus</button>
            </td>
        `;
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
        const harga = select.options[select.selectedIndex].dataset.harga || 0;
        const row = select.closest('tr');
        row.querySelector('.harga').value = parseFloat(harga).toFixed(2);
        updateSubtotal(row.querySelector('.jumlah'));
    }

    function updateSubtotal(input) {
        const row = input.closest('tr');
        const jumlah = parseFloat(row.querySelector('.jumlah').value) || 0;
        const harga = parseFloat(row.querySelector('.harga').value) || 0;
        const subtotal = jumlah * harga;
        row.querySelector('.subtotal').textContent = subtotal.toFixed(2);
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal').forEach(subtotal => {
            total += parseFloat(subtotal.textContent) || 0;
        });
        document.getElementById('total').textContent = this.formatRupiah(total.toFixed(2));
    }

    function formatRupiah(angka) {
        return "Rp " + parseFloat(angka).toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush