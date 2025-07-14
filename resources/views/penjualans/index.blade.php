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
        <h1>Daftar Transaksi</h1>
        <div class="button-group">
            <a href="{{ route('penjualans.create') }}" class="btn btn-success btn-sm">Transaksi Baru</a>
            <a href="#" class="btn btn-primary btn-sm">Lihat Laporan</a>
            <a href="#" class="btn btn-secondary btn-sm">Ekspor Data</a>
        </div>
    </div>
    <!-- Konten lainnya -->


    <table id="penjualanTable" class="table table-striped">
        <thead>
            <tr>
                <th>Kode Penjualan</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Bayar</th>
                <th>Kembali</th>
                <th>Metode Pembayaran</th>
                <th>Status Pembayaran</th>
                <th>Status Pengiriman</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus penjualan ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
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
    #penjualanTable_wrapper {
        width: 100% !important;
    }

    #penjualanTable {
        width: 100% !important;
    }

    .dataTables_scrollBody {
        width: 100% !important;
    }

    /* Prevent text wrapping and truncation in table cells */
    #penjualanTable td,
    #penjualanTable th {
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    /* Specific styling for action column */
    #penjualanTable td:last-child {
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
    #penjualanTable tbody tr {
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
        $('#penjualanTable').DataTable({
            
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

            ajax: '{{ route("penjualans.index") }}',
            columns: [{
                    data: 'kode_penjualan',
                    name: 'kode_penjualan'
                },
                {
                    data: 'tanggal_penjualan',
                    name: 'tanggal_penjualan'
                },
                {
                    data: 'waktu_penjualan',
                    name: 'waktu_penjualan'
                },
                {
                    data: 'nama_pelanggan',
                    name: 'nama_pelanggan',
                    render: function(data) {
                        return data || '-';
                    }
                },
                {
                    data: 'total_akhir',
                    name: 'total_akhir',
                    render: function(data) {
                        return 'Rp ' + parseFloat(data).toLocaleString('id-ID', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    }
                },
                {
                    data: 'jumlah_bayar',
                    name: 'jumlah_bayar',
                    render: function(data) {
                        return 'Rp ' + parseFloat(data).toLocaleString('id-ID', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    }
                },
                {
                    data: 'kembalian',
                    name: 'kembalian',
                    render: function(data) {
                        return 'Rp ' + parseFloat(data).toLocaleString('id-ID', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    }
                },
                {
                    data: 'metode_pembayaran',
                    name: 'metode_pembayaran',
                    render: function(data, type, row) {
                        switch (data) {
                            case 'tunai':
                                return '<span class="badge bg-success">Tunai</span>';
                            case 'transfer':
                                return '<span class="badge bg-primary">Transfer</span>';
                            case 'kartu_kredit':
                                return '<span class="badge bg-danger">Kartu Kredit</span>';
                            case 'kartu_debit':
                                return '<span class="badge bg-info">Kartu Debit</span>';
                            case 'e_wallet':
                                return '<span class="badge bg-warning text-dark">E-Wallet</span>';
                            default:
                                return '<span class="badge bg-secondary">' + data + '</span>';
                        }
                    }
                },
                {
                    data: 'status_pembayaran',
                    name: 'status_pembayaran',
                    render: function(data, type, row) {
                        let textColor, textLabel;

                        switch (data) {
                            case 'lunas':
                                textColor = 'color: green;'; // Green text for Lunas
                                textLabel = 'Lunas';
                                break;
                            case 'belum_lunas':
                                textColor = 'color: red;'; // Red text for Belum Lunas
                                textLabel = 'Belum Lunas';
                                break;
                            case 'sebagian':
                                textColor = 'color: #ffc107;'; // Yellow (hex code for warning-like color) for Sebagian
                                textLabel = 'Sebagian';
                                break;
                            default:
                                textColor = 'color: gray;'; // Gray text for unknown status
                                textLabel = 'Unknown';
                        }

                        return `<span style="${textColor}">${textLabel}</span>`;
                    }
                },
                {
                    data: 'status_pengiriman',
                    name: 'status_pengiriman',
                    render: function(data, type, row) {
                        switch (data) {
                            case 'sudah_dikirim':
                                return '<span class="badge bg-success">Sudah Dikirim</span>';
                            case 'sedang_dikirim':
                                return '<span class="badge bg-primary">Sedang Dikirim</span>';
                            case 'belum_dikirim':
                                return '<span class="badge bg-danger">Belum Dikirim</span>';
                            
                            default:
                                return '<span class="badge bg-secondary">' + data + '</span>';
                        }
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                        <a href="{{ url('penjualans') }}/${row.id}/edit" class="btn btn-sm btn-primary">Edit</a>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">Hapus</button>
                    `;
                    }
                }
            ]
        });

        $(document).on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            const deleteForm = $('#deleteForm');
            deleteForm.attr('action', `{{ url('penjualans') }}/${id}`);
            $('#deleteModal').modal('show');
        });
    });
</script>
@endpush