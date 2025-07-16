@extends('dasbor')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Daftar Produk</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createProductModal">
                                    <i class="fas fa-plus"></i> Tambah Produk
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="toggleColumns">
                                    <i class="fas fa-columns"></i> Atur Kolom
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="resetTable">
                                    <i class="fas fa-refresh"></i> Reset
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end">
                                <small class="text-muted">Geser horizontal untuk melihat semua kolom</small>
                            </div>
                        </div>
                    </div>

                    <!-- Custom Filter Section -->
                    <form id="filter-form">
                        <div class="row g-3">
                            <!-- Kategori -->
                            <div class="col-md-4">
                                <label for="filter-kategori" class="form-label">Kategori</label>
                                <select id="filter-kategori" name="kategori" class="form-select">
                                    <option value="">All</option>
                                    @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Merek -->
                            <div class="col-md-4">
                                <label for="filter-merek" class="form-label">Merek</label>
                                <select id="filter-merek" name="merek" class="form-select">
                                    <option value="">All</option>
                                    @foreach ($mereks as $merek)
                                    <option value="{{ $merek->id }}">{{ $merek->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="col-md-4">
                                <label for="filter-status" class="form-label">Status</label>
                                <select id="filter-status" name="status" class="form-select">
                                    <option value="">All</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <!-- Stok (Min) -->
                            <div class="col-md-4">
                                <label for="filter-stok" class="form-label">Stok (Min)</label>
                                <input type="number" id="filter-stok" name="stok" class="form-control" min="0" placeholder="0">
                            </div>

                            <!-- Harga Min -->
                            <div class="col-md-4">
                                <label for="filter-harga-min" class="form-label">Harga Min (jual)</label>
                                <input type="number" id="filter-harga-min" name="harga_min" class="form-control" min="0" placeholder="0">
                            </div>

                            <!-- Harga Max -->
                            <div class="col-md-4">
                                <label for="filter-harga-max" class="form-label">Harga Max (jual)</label>
                                <input type="number" id="filter-harga-max" name="harga_max" class="form-control" min="0" placeholder="0">
                            </div>

                            <!-- Barcode -->
                            <div class="col-md-4">
                                <label for="filter-barcode" class="form-label">Barcode</label>
                                <input type="text" id="filter-barcode" name="barcode" class="form-control" placeholder="1234567890">
                            </div>

                            <!-- Satuan -->
                            <div class="col-md-4">
                                <label for="filter-satuan" class="form-label">Satuan</label>
                                <input type="text" id="filter-satuan" name="satuan" class="form-control" placeholder="e.g., pcs, kg">
                            </div>

                            <!-- Buttons -->
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="btn-group w-100">
                                    <button type="button" id="filter-apply" class="btn btn-primary">Apply Filters</button>
                                    <button type="button" id="filter-clear" class="btn btn-secondary">Clear Filters</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive mt-4">
                        <table id="productsTable" class="table table-hover table-striped dt-responsive nowrap" style="width:100%">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="">Gambar</th>
                                    <th>Nama</th>
                                    <th class="">Slug</th>
                                    <th>Deskripsi</th>
                                    <th>Harga Jual</th>
                                    <th class="">Harga Modal</th>
                                    <th>Stok</th>
                                    <th class="">Kode SKU</th>
                                    <th class="">Barcode</th>
                                    <th class="">Kategori</th>
                                    <th class="">Merek</th>
                                    <th class="">Satuan</th>
                                    <th class="">Berat</th>
                                    <th class="">Dimensi</th>
                                    <th>Status</th>
                                    <th class="">Stok Min</th>
                                    <th class="">Dibuat</th>
                                    <th class="">Diperbarui</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Column Visibility -->
<div class="modal fade" id="columnModal" tabindex="-1" aria-labelledby="columnModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="columnModalLabel">Atur Visibilitas Kolom</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row" id="columnToggles">
                    <!-- Column toggles akan diisi oleh JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="applyColumns">Terapkan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Create Product -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductModalLabel">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="harga_jual" class="form-label">Harga Jual</label>
                            <input type="number" class="form-control" id="harga_jual" name="harga_jual" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="harga_modal" class="form-label">Harga Modal</label>
                            <input type="number" class="form-control" id="harga_modal" name="harga_modal" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="jumlah_stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="jumlah_stok" name="jumlah_stok" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="kode_sku" class="form-label">Kode SKU</label>
                            <input type="text" class="form-control" id="kode_sku" name="kode_sku">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="kode_barcode" class="form-label">Barcode</label>
                            <input type="text" class="form-control" id="kode_barcode" name="kode_barcode">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="id_kategori" class="form-label">Kategori</label>
                            <select class="form-control" id="id_kategori" name="id_kategori">
                                <option value="">Pilih Kategori</option>
                                <!-- Options will be filled by AJAX -->
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="id_merek" class="form-label">Merek</label>
                            <select class="form-control" id="id_merek" name="id_merek">
                                <option value="">Pilih Merek</option>
                                <!-- Options will be filled by AJAX -->
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="satuan" name="satuan">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="berat" class="form-label">Berat (kg)</label>
                            <input type="number" step="0.01" class="form-control" id="berat" name="berat">
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Dimensi (cm)</label>
                            <div class="row">
                                <div class="col">
                                    <input type="number" step="0.1" class="form-control" placeholder="Panjang" name="panjang">
                                </div>
                                <div class="col">
                                    <input type="number" step="0.1" class="form-control" placeholder="Lebar" name="lebar">
                                </div>
                                <div class="col">
                                    <input type="number" step="0.1" class="form-control" placeholder="Tinggi" name="tinggi">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="stok_minimum" class="form-label">Stok Minimum</label>
                            <input type="number" class="form-control" id="stok_minimum" name="stok_minimum">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="aktif" class="form-label">Status</label>
                            <select class="form-control" id="aktif" name="aktif">
                                <option value="1">Aktif</option>
                                <option value="0">Non-Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveProduct">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Update Product -->
<div class="modal fade" id="updateProductModal" tabindex="-1" aria-labelledby="updateProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProductModalLabel">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateProductForm">
                    <input type="hidden" name="id" id="update_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="update_nama" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="update_nama" name="nama" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="update_slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="update_slug" name="slug" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="update_deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="update_deskripsi" name="deskripsi" rows="4"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="update_harga_jual" class="form-label">Harga Jual</label>
                            <input type="number" class="form-control" id="update_harga_jual" name="harga_jual" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="update_harga_modal" class="form-label">Harga Modal</label>
                            <input type="number" class="form-control" id="update_harga_modal" name="harga_modal" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="update_jumlah_stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="update_jumlah_stok" name="jumlah_stok" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="update_kode_sku" class="form-label">Kode SKU</label>
                            <input type="text" class="form-control" id="update_kode_sku" name="kode_sku">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="update_kode_barcode" class="form-label">Barcode</label>
                            <input type="text" class="form-control" id="update_kode_barcode" name="kode_barcode">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="update_id_kategori" class="form-label">Kategori</label>
                            <select class="form-control" id="update_id_kategori" name="id_kategori">
                                <option value="">Pilih Kategori</option>
                                <!-- Options will be filled by AJAX -->
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="update_id_merek" class="form-label">Merek</label>
                            <select class="form-control" id="update_id_merek" name="id_merek">
                                <option value="">Pilih Merek</option>
                                <!-- Options will be filled by AJAX -->
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="update_satuan" class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="update_satuan" name="satuan">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="update_berat" class="form-label">Berat (kg)</label>
                            <input type="number" step="0.01" class="form-control" id="update_berat" name="berat">
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Dimensi (cm)</label>
                            <div class="row">
                                <div class="col">
                                    <input type="number" step="0.1" class="form-control" placeholder="Panjang" name="panjang" id="update_panjang">
                                </div>
                                <div class="col">
                                    <input type="number" step="0.1" class="form-control" placeholder="Lebar" name="lebar" id="update_lebar">
                                </div>
                                <div class="col">
                                    <input type="number" step="0.1" class="form-control" placeholder="Tinggi" name="tinggi" id="update_tinggi">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for=" Conflict with previous version: stok_minimum" class="form-label">Stok Minimum</label>
                            <input type="number" class="form-control" id="update_stok_minimum" name="stok_minimum">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="update_aktif" class="form-label">Status</label>
                            <select class="form-control" id="update_aktif" name="aktif">
                                <option value="1">Aktif</option>
                                <option value="0">Non-Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="update_gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="update_gambar" name="gambar" accept="image/*">
                            <img id="current_image" class="mt-2 img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="updateProduct">Perbarui</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Delete Confirmation -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus produk ini?
                <input type="hidden" id="delete_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom responsive styles */
    @media (max-width: 768px) {
        .table-responsive {
            border: none;
        }

        .table td {
            padding: 0.5rem 0.25rem;
            font-size: 0.875rem;
        }

        .table th {
            padding: 0.5rem 0.25rem;
            font-size: 0.875rem;
        }
    }

    /* DataTables responsive styles */
    table.dataTable.dt-responsive tbody tr.child {
        background-color: #f8f9fa;
    }

    table.dataTable.dt-responsive tbody tr.child td {
        border-top: 1px solid #dee2e6;
    }

    table.dataTable.dt-responsive tbody tr.child:first-child td {
        border-top: none;
    }

    /* Custom column toggle styles */
    .column-toggle {
        margin-bottom: 10px;
    }

    .column-toggle .form-check-input {
        margin-right: 10px;
    }

    /* Responsive badge styles */
    .badge {
        font-size: 0.75rem;
    }

    @media (max-width: 576px) {
        .badge {
            font-size: 0.65rem;
        }
    }

    /* Action buttons */
    .action-buttons .btn {
        margin-right: 5px;
    }
</style>
@endpush

@push('scripts')
<!-- DataTables CSS with Bootstrap 5 integration -->
<link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.min.css" rel="stylesheet">

<!-- DataTables JS with Bootstrap 5 and Responsive extensions -->
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTable dengan opsi responsive
        var table = $('#productsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("produks.datatable") }}',
                data: function(d) {
                    d.kategori = $('#filter-kategori').val();
                    d.merek = $('#filter-merek').val();
                    d.status = $('#filter-status').val();
                    d.stok = $('#filter-stok').val();
                    d.harga_min = $('#filter-harga-min').val();
                    d.harga_max = $('#filter-harga-max').val();
                    d.barcode = $('#filter-barcode').val();
                    d.satuan = $('#filter-satuan').val();
                }
            },
            columns: [{
                    data: null,
                    name: 'no',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'gambar',
                    name: 'gambar',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return '<img src="' + data + '" alt="' + row.id + '" class="img-thumbnail" style="width: 40px; height: 40px; object-fit: cover;">';
                    }
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'slug',
                    name: 'slug'
                },
                {
                    data: 'deskripsi',
                    name: 'deskripsi',
                    render: function(data) {
                        if (!data) return '-';
                        return data.length > 30 ? data.substr(0, 30) + '...' : data;
                    }
                },
                {
                    data: 'harga_jual',
                    name: 'harga_jual',
                    className: 'text-end',
                    render: function(data) {
                        return 'Rp ' + parseFloat(data).toLocaleString('id-ID', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    }
                },
                {
                    data: 'harga_modal',
                    name: 'harga_modal',
                    className: 'text-end',
                    render: function(data) {
                        return 'Rp ' + parseFloat(data).toLocaleString('id-ID', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    }
                },
                {
                    data: 'jumlah_stok',
                    name: 'jumlah_stok',
                    className: 'text-center',
                    render: function(data, type, row) {
                        var badgeClass = data <= row.stok_minimum ? 'bg-danger' : 'bg-success';
                        return '<span class="badge ' + badgeClass + '">' + data + '</span>';
                    }
                },
                {
                    data: 'kode_sku',
                    name: 'kode_sku'
                },
                {
                    data: 'kode_barcode',
                    name: 'kode_barcode'
                },
                {
                    data: 'kategori.nama',
                    name: 'kategori.nama',
                    defaultContent: '-',
                    render: function(data) {
                        return data ? '<span class="badge bg-info">' + data + '</span>' : '-';
                    }
                },
                {
                    data: 'merek.nama',
                    name: 'merek.nama',
                    defaultContent: '-',
                    render: function(data) {
                        return data ? '<span class="badge bg-secondary">' + data + '</span>' : '-';
                    }
                },
                {
                    data: 'satuan',
                    name: 'satuan'
                },
                {
                    data: 'berat',
                    name: 'berat',
                    className: 'text-end',
                    render: function(data) {
                        return parseFloat(data).toFixed(2) + ' kg';
                    }
                },
                {
                    data: 'dimensi',
                    name: 'dimensi',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return parseFloat(row.panjang).toFixed(1) + ' x ' +
                            parseFloat(row.lebar).toFixed(1) + ' x ' +
                            parseFloat(row.tinggi).toFixed(1) + ' cm';
                    }
                },
                {
                    data: 'aktif',
                    name: 'aktif',
                    className: 'text-center',
                    render: function(data) {
                        return data ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Non-Aktif</span>';
                    }
                },
                {
                    data: 'stok_minimum',
                    name: 'stok_minimum',
                    className: 'text-center'
                },

                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data) {
                        return new Date(data).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                    render: function(data) {
                        return new Date(data).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center action-buttons',
                    render: function(data, type, row) {
                        return `
                        <button class="btn btn-sm btn-warning edit-btn" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}"><i class="fas fa-trash"></i></button>
                    `;
                    }
                }
            ],
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            language: {
                processing: "Memproses...",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                search: "Cari:",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            fixedHeader: true,
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: true
        });

        // Apply filters on button click
        $('#filter-apply').on('click', function() {
            table.draw();
        });

        // Clear Filters Button
        $('#filter-clear').on('click', function() {
            $('#filter-form')[0].reset(); // Reset all form inputs
            table.draw(); // Redraw table with no filters
        });

        // Setup column visibility modal
        setupColumnVisibility(table);

        // Toggle columns button
        $('#toggleColumns').click(function() {
            $('#columnModal').modal('show');
        });

        // Reset table button
        $('#resetTable').click(function() {
            table.columns().visible(true);
            table.ajax.reload();
        });

        // Apply column visibility
        $('#applyColumns').click(function() {
            $('.column-toggle input[type="checkbox"]').each(function() {
                var column = table.column($(this).data('column'));
                column.visible($(this).is(':checked'));
            });
            $('#columnModal').modal('hide');
        });

        // Load categories and brands
        function loadCategoriesAndBrands() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '{{ route("produks.getCategoriesAndBrands") }}',
                    method: 'GET',
                    success: function(data) {
                        // Populate create modal
                        $('#id_kategori').empty().append('<option value="">Pilih Kategori</option>');
                        $.each(data.categories, function(i, category) {
                            $('#id_kategori').append(`<option value="${category.id}">${category.nama}</option>`);
                        });

                        $('#id_merek').empty().append('<option value="">Pilih Merek</option>');
                        $.each(data.brands, function(i, brand) {
                            $('#id_merek').append(`<option value="${brand.id}">${brand.nama}</option>`);
                        });

                        // Populate update modal
                        $('#update_id_kategori').empty().append('<option value="">Pilih Kategori</option>');
                        $.each(data.categories, function(i, category) {
                            $('#update_id_kategori').append(`<option value="${category.id}">${category.nama}</option>`);
                        });

                        $('#update_id_merek').empty().append('<option value="">Pilih Merek</option>');
                        $.each(data.brands, function(i, brand) {
                            $('#update_id_merek').append(`<option value="${brand.id}">${brand.nama}</option>`);
                        });

                        resolve(); // Resolve the promise when done
                    },
                    error: function(xhr) {
                        reject(xhr); // Reject the promise on error
                    }
                });
            });
        }

        // Load categories and brands when modal opens
        $('#createProductModal').on('show.bs.modal', function() {
            loadCategoriesAndBrands();
            $('#createProductForm')[0].reset();
        });

        // Create product
        $('#saveProduct').click(function() {
            var formData = new FormData($('#createProductForm')[0]);

            $.ajax({
                url: '{{ route("produks.store") }}',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#createProductModal').modal('hide');
                        table.ajax.reload();
                        alert('Produk berhasil ditambahkan!');
                        $('#createProductForm')[0].reset();
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.error);
                }
            });
        });

        // Edit product
        $(document).on('click', '.edit-btn', function() {
            var id = $(this).data('id');

            $.ajax({
                url: '{{ route("produks.show", ":id") }}'.replace(':id', id),
                method: 'GET',
                success: function(response) {
                    const data = response.data;
                    // Store the data to use after categories and brands are loaded
                    $('#update_id').val(data.id);
                    $('#update_nama').val(data.nama);
                    $('#update_slug').val(data.slug);
                    $('#update_deskripsi').val(data.deskripsi);
                    $('#update_harga_jual').val(data.harga_jual);
                    $('#update_harga_modal').val(data.harga_modal);
                    $('#update_jumlah_stok').val(data.jumlah_stok);
                    $('#update_kode_sku').val(data.kode_sku);
                    $('#update_kode_barcode').val(data.kode_barcode);
                    $('#update_satuan').val(data.satuan);
                    $('#update_berat').val(data.berat);
                    $('#update_panjang').val(data.panjang);
                    $('#update_lebar').val(data.lebar);
                    $('#update_tinggi').val(data.tinggi);
                    $('#update_stok_minimum').val(data.stok_minimum);
                    $('#update_aktif').val(data.aktif ? '1' : '0');
                    $('#current_image').attr('src', data.gambar);

                    // Load categories and brands, then set the selected values
                    loadCategoriesAndBrands().then(() => {
                        $('#update_id_kategori').val(data.id_kategori);
                        $('#update_id_merek').val(data.id_merek);
                        $('#updateProductModal').modal('show');
                    });
                }
            });
        });

        // Update product
        $('#updateProduct').click(function() {
            var formData = new FormData($('#updateProductForm')[0]);

            $.ajax({
                url: '{{ route("produks.update", ":id") }}'.replace(':id', $('#update_id').val()),
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    '_method': 'POST'
                },
                success: function(response) {
                    if (response.success) {
                        $('#updateProductModal').modal('hide');
                        table.ajax.reload();
                        alert('Produk berhasil diperbarui!');
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.error);
                }
            });
        });

        // Delete product
        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            $('#delete_id').val(id);
            $('#deleteProductModal').modal('show');
        });

        // Confirm delete
        $('#confirmDelete').click(function() {
            var id = $('#delete_id').val();

            $.ajax({
                url: '{{ route("produks.destroy", ":id") }}'.replace(':id', id),
                method: 'DELETE',
                headers: {
                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    '_method': 'DELETE'
                },
                success: function(response) {
                    if (response.success) {
                        $('#deleteProductModal').modal('hide');
                        table.ajax.reload();
                        alert('Produk berhasil dihapus!');
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.error);
                }
            });
        });

        // Responsive breakpoint handling
        $(window).resize(function() {
            // table.columns.adjust().responsive.recalc();
        });
    });

    function setupColumnVisibility(table) {
        var columnToggles = $('#columnToggles');
        var columnNames = [
            'No', 'Gambar', 'Nama', 'Slug', 'Deskripsi', 'Harga Jual', 'Harga Modal',
            'Stok', 'Kode SKU', 'Barcode', 'Kategori', 'Merek', 'Satuan',
            'Berat', 'Dimensi', 'Status', 'Stok Min', 'Dibuat', 'Diperbarui', 'Aksi'
        ];

        columnToggles.empty();
        table.columns().every(function(index) {
            var column = this;
            var columnName = columnNames[index] || 'Kolom ' + (index + 1);

            var toggle = $('<div class="col-md-6 column-toggle">' +
                '<div class="form-check">' +
                '<input class="form-check-input" type="checkbox" id="col' + index + '" data-column="' + index + '" ' + (column.visible() ? 'checked' : '') + '>' +
                '<label class="form-check-label" for="col' + index + '">' + columnName + '</label>' +
                '</div>' +
                '</div>');

            columnToggles.append(toggle);
        });
    }
</script>
@endpush