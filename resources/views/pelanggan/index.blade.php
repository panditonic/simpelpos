@extends('dasbor')

@section('content')
<div class="container-fluid">
    <h1>Daftar Pelanggan</h1>
    <a href="{{ route('pelanggans.create') }}" class="btn btn-success mb-3">Tambah Pelanggan</a>
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Column Visibility and Filters -->
    <div class="card mb-3">
        <div class="card-header">Filter & Column Visibility</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="columnVisibilityControl">Tampilkan/Sembunyikan Kolom:</label>
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
<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css" rel="stylesheet">

<!-- Select2 for better multi-select experience -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- DataTables JS with Bootstrap 5 and Responsive extensions -->
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
            responsive: true,
            autoWidth: false,
            ajax: {
                url: '{{ route("pelanggans.datatable") }}',
                data: function(d) {
                    d.nama = $('#filterNama').val();
                    d.email = $('#filterEmail').val();
                    d.status_aktif = $('#filterStatus').val();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nama', name: 'nama' },
                { data: 'email', name: 'email' },
                { data: 'telepon', name: 'telepon' },
                { data: 'status_aktif', name: 'status_aktif' },
                { 
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false 
                }
            ],
            columnDefs: [
                {
                    targets: '_all',
                    visible: true // All columns visible by default
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
                table.column(5).visible(true); // Ensure Action column is always visible

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
</script>
@endpush