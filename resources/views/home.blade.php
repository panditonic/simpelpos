@extends('dasbor')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Dashboard Analitik</h1>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card primary">
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3 id="totalSales">0</h3>
                <p>Total Penjualan Hari Ini</p>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card success">
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h3 id="totalRevenue">Rp 0</h3>
                <p>Pendapatan Hari Ini</p>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card warning">
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <h3 id="totalProducts">0</h3>
                <p>Total Produk</p>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card danger">
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 id="lowStock">0</h3>
                <p>Stok Hampir Habis</p>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <div class="col-xl-12">
            <div class="chart-container">
                <div class="chart-title">Grafik Penjualan Mingguan</div>
                <canvas id="salesChart" width="400" height="150"></canvas>
            </div>
        </div>

        <div class="col-xl-4 col-sm-4">
            <div class="chart-container">
                <div class="chart-title">Produk Terlaris</div>
                <canvas id="topProductsChart" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="col-xl-4 col-sm-4">
            <div class="chart-container">
                <div class="chart-title">Produk Terlaris</div>
                <canvas id="topProductsChart1" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="col-xl-4 col-sm-4">
            <div class="chart-container">
                <div class="chart-title">Produk Terlaris</div>
                <canvas id="topProductsChart2" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Sales -->
    <div class="row">
        <div class="col-12">
            <div class="recent-sales">
                <h5 class="mb-3">Transaksi Terbaru</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="recentSalesTable">
                            <!-- Data will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Sample data animation
    function animateNumber(element, target, duration = 1000) {
        const start = 0;
        const startTime = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const current = Math.floor(start + (target - start) * progress);

            if (element.id === 'totalRevenue') {
                element.textContent = 'Rp ' + current.toLocaleString('id-ID');
            } else {
                element.textContent = current.toLocaleString('id-ID');
            }

            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }

        requestAnimationFrame(update);
    }

    // Initialize dashboard data
    window.addEventListener('load', function() {
        // Animate stats
        animateNumber(document.getElementById('totalSales'), 142);
        animateNumber(document.getElementById('totalRevenue'), 8450000);
        animateNumber(document.getElementById('totalProducts'), 1250);
        animateNumber(document.getElementById('lowStock'), 23);

        const datestring = Date.now();

        // Populate recent sales table
        const recentSales = [{
                id: 'TRX001',
                customer: 'Budi Santoso',
                product: 'Smartphone Samsung',
                qty: 1,
                total: 3500000,
                time: '10:30',
                status: 'Selesai'
            },
            {
                id: 'TRX002',
                customer: 'Siti Nurhaliza',
                product: 'Laptop Asus',
                qty: 1,
                total: 7200000,
                time: '11:15',
                status: 'Proses'
            },
            {
                id: 'TRX003',
                customer: 'Ahmad Rizki',
                product: 'Headphone Sony',
                qty: 2,
                total: 850000,
                time: '12:00',
                status: 'Selesai'
            },
            {
                id: 'TRX004',
                customer: 'Maya Sari',
                product: 'Tablet iPad',
                qty: 1,
                total: 4500000,
                time: '13:45',
                status: 'Selesai'
            },
            {
                id: 'TRX005',
                customer: 'Doni Pratama',
                product: 'Speaker JBL',
                qty: 1,
                total: 1200000,
                time: '14:20',
                status: 'Proses'
            }
        ];

        const tableBody = document.getElementById('recentSalesTable');
        recentSales.forEach(sale => {
            const row = document.createElement('tr');
            const statusClass = sale.status === 'Selesai' ? 'success' : 'warning';
            row.innerHTML = `
                    <td><strong>${sale.id}</strong></td>
                    <td>${sale.customer}</td>
                    <td>${sale.product}</td>
                    <td>${sale.qty}</td>
                    <td>Rp ${sale.total.toLocaleString('id-ID')}</td>
                    <td>${sale.time}</td>
                    <td><span class="badge bg-${statusClass}">${sale.status}</span></td>
                `;
            tableBody.appendChild(row);
        });
    });

    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            datasets: [{
                label: 'Penjualan (Rp)',
                data: [5200000, 7800000, 6500000, 8200000, 9100000, 12500000, 8450000],
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Top Products Chart
    const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
    new Chart(topProductsCtx, {
        type: 'doughnut',
        data: {
            labels: ['Smartphone', 'Laptop', 'Tablet', 'Headphone', 'Speaker'],
            datasets: [{
                data: [35, 25, 20, 12, 8],
                backgroundColor: [
                    '#667eea',
                    '#2ecc71',
                    '#f39c12',
                    '#e74c3c',
                    '#9b59b6'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Top Products Chart
    const topProductsCtx1 = document.getElementById('topProductsChart1').getContext('2d');
    new Chart(topProductsCtx1, {
        type: 'pie',
        data: {
            labels: ['Smartphone', 'Laptop', 'Tablet', 'Headphone', 'Speaker'],
            datasets: [{
                data: [35, 25, 20, 12, 8],
                backgroundColor: [
                    '#667eea',
                    '#2ecc71',
                    '#f39c12',
                    '#e74c3c',
                    '#9b59b6'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Top Products Chart
    const topProductsCtx2 = document.getElementById('topProductsChart2').getContext('2d');
    new Chart(topProductsCtx2, {
        type: 'doughnut',
        data: {
            labels: ['Smartphone', 'Laptop', 'Tablet', 'Headphone', 'Speaker'],
            datasets: [{
                data: [35, 25, 20, 12, 8],
                backgroundColor: [
                    '#667eea',
                    '#2ecc71',
                    '#f39c12',
                    '#e74c3c',
                    '#9b59b6'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush