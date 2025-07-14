@extends('dasbor')

@section('content')


<div class="container-fluid">

    <style>
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .header-container h1 {
            font-size: 1.5rem;
            /* Ukuran judul lebih kecil */
            margin: 0;
        }

        .button-group {
            display: flex;
            gap: 0.5rem;
            /* Jarak antar tombol */
        }
    </style>
    <div class="header-container">
        <h1>Daftar Pelanggan</h1>
        <div class="button-group">
            <a href="{{ route('pelanggans.create') }}" class="btn btn-success btn-sm">Tambah Pelanggan</a>
            <a href="#" class="btn btn-primary btn-sm">Lihat Laporan</a>
            <a href="#" class="btn btn-secondary btn-sm">Ekspor Data</a>
        </div>
    </div>
    <!-- Konten lainnya -->

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Column Visibility and Filters -->
    <div class="card mb-3">
        <div class="card-header">Filter & Column Visibility</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="columnVisibilityControl">Kolom:</label>
                    <select id="columnVisibilityControl" class="form-select" multiple>
                        <option value="0">ID</option>
                        <option value="1">Nama</option>
                        <option value="2">Email</option>
                        <option value="3">Telepon</option>
                        <option value="4">Status</option>
                    </select>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="filterNama">Filter Nama:</label>
                            <input type="text" id="filterNama" class="form-control" placeholder="Cari Nama...">
                        </div>
                        <div class="col-md-4">
                            <label for="filterEmail">Filter Email:</label>
                            <input type="text" id="filterEmail" class="form-control" placeholder="Cari Email...">
                        </div>
                        <div class="col-md-4">
                            <label for="filterStatus">Filter Status:</label>
                            <select id="filterStatus" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <table id="pelangganTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Jenis Kelamin</th>
                <th>Pekerjaan</th>
                <th>No KTP</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@endsection

@push('scripts')
<!-- DataTables CSS with Bootstrap 5 integration -->
<link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.min.css" rel="stylesheet">

<!-- Select2 for better multi-select experience -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- DataTables JS with Bootstrap 5 and Responsive extensions -->
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

<style>
    /* Ensure DataTable wrapper and table are full-width */
    #pelangganTable_wrapper {
        width: 100% !important;
    }

    #pelangganTable {
        width: 100% !important;
    }

    .dataTables_scrollBody {
        width: 100% !important;
    }

    /* Prevent text wrapping and truncation in table cells */
    #pelangganTable td,
    #pelangganTable th {
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    /* Specific styling for action column */
    #pelangganTable td:last-child {
        min-width: 120px;
        /* Minimum width for action buttons */
        max-width: 200px;
        /* Maximum width for action buttons */
    }

    /* Inline action buttons styling */
    .action-buttons {
        display: inline-flex !important;
        gap: 5px !important;
        align-items: center !important;
        flex-wrap: nowrap !important;
    }

    .action-buttons .btn {
        padding: 2px 8px !important;
        font-size: 12px !important;
        line-height: 1.2 !important;
        border-radius: 3px !important;
        margin: 0 !important;
        display: inline-block !important;
    }

    /* Ensure status badges are inline */
    .status-badge {
        display: inline-block !important;
        padding: 2px 8px !important;
        font-size: 11px !important;
        border-radius: 12px !important;
    }

    /* Remove fixed row height to allow content to dictate height */
    #pelangganTable tbody tr {
        height: auto !important;
    }

    .select2 {
        width: 100% !important;
    }

    .select2-container {
        display: inline !important;
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize Select2 for column visibility - START EMPTY
        $('#columnVisibilityControl').select2({
            placeholder: "Pilih kolom untuk ditampilkan",
            allowClear: true
        });
        // Do not set any default values - leave it empty

        // Initialize DataTable
        var table = $('#pelangganTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false, // Disable responsive to maintain single line
            autoWidth: false,
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
            fixedColumns: true,
            ajax: {
                url: '{{ route("pelanggans.datatable") }}',
                data: function(d) {
                    d.nama = $('#filterNama').val();
                    d.email = $('#filterEmail').val();
                    d.status_aktif = $('#filterStatus').val();
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    width: '50px'
                },
                {
                    data: 'nama',
                    name: 'nama',
                    width: '150px'
                },
                {
                    data: 'email',
                    name: 'email',
                    width: '180px'
                },
                {
                    data: 'telepon',
                    name: 'telepon',
                    width: '120px'
                },
                {
                    data: 'jenis_kelamin',
                    name: 'jenis_kelamin',
                    width: '80px'
                },
                {
                    data: 'pekerjaan',
                    name: 'pekerjaan',
                    width: '120px'
                },
                {
                    data: 'no_ktp',
                    name: 'no_ktp',
                    width: '130px'
                },
                {
                    data: 'status_aktif',
                    name: 'status_aktif',
                    width: '80px',
                    render: function(data, type, row) {
                        if (data == 1) {
                            return '<span class="badge bg-success status-badge">Aktif</span>';
                        } else {
                            return '<span class="badge bg-danger status-badge">Tidak Aktif</span>';
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '150px',
                    render: function(data, type, row) {
                        return `
                            <div class="action-buttons">
                                <a href="/pelanggans/${row.id}" class="btn btn-info btn-sm" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="/pelanggans/${row.id}/edit" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(${row.id})" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            columnDefs: [{
                    targets: '_all',
                    visible: true,
                    // className: 'text-center'
                },
                {
                    targets: [1, 2, 4, 5], // Nama, Email, Jenis Kelamin, Pekerjaan
                    className: 'text-left'
                }
            ]
        });

        // Column visibility control - ONLY TRIGGER WHEN THERE ARE SELECTIONS
        $('#columnVisibilityControl').on('change', function() {
            var selectedColumns = $(this).val() || [];

            // Only apply column visibility if there are selected columns
            if (selectedColumns.length > 0) {
                // Hide all columns except Action column
                table.columns().visible(false);
                table.column(8).visible(true); // Ensure Action column is always visible

                // Show selected columns
                selectedColumns.forEach(function(colIdx) {
                    if (table.column(colIdx)) {
                        table.column(colIdx).visible(true);
                    }
                });
            } else {
                // If no columns selected, show all columns
                table.columns().visible(true);
            }

            // Redraw table to adjust layout
            table.columns.adjust().draw(false);
        });

        // Handle Select2 clear event - show all columns when cleared
        $('#columnVisibilityControl').on('select2:clear', function() {
            table.columns().visible(true); // Show all columns
            table.columns.adjust().draw(false); // Adjust and redraw
        });

        // Custom filter event handlers
        $('#filterNama, #filterEmail').on('keyup', function() {
            table.draw();
        });

        $('#filterStatus').on('change', function() {
            table.draw();
        });

        // Adjust table on window resize
        $(window).on('resize', function() {
            table.columns.adjust().draw(false);
        });
    });

    // Function to confirm delete action
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')) {
            // Create form and submit
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '/pelanggans/' + id;

            var methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';

            var tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = '{{ csrf_token() }}';

            form.appendChild(methodInput);
            form.appendChild(tokenInput);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush