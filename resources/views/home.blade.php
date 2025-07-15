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

    <!-- Weekly Performance Summary -->
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-1">Performa Minggu Ini</h5>
                        <p class="mb-0">Penjualan 7 hari terakhir (termasuk hari ini)</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <h4 class="mb-0">
                            <span class="badge bg-{{ $chartData['weekGrowth'] >= 0 ? 'success' : 'danger' }}">
                                {{ $chartData['weekGrowth'] >= 0 ? '+' : '' }}{{ $chartData['weekGrowth'] }}%
                            </span>
                        </h4>
                        <small class="text-muted">vs minggu lalu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <div class="col-xl-12">
            <div class="chart-container">
                <div class="chart-title">
                    Grafik Penjualan 7 Hari Terakhir
                    <small class="text-muted ms-2">({{ Carbon\Carbon::now('Asia/Jayapura')->subDays(6)->format('d M') }} - {{ Carbon\Carbon::now('Asia/Jayapura')->format('d M Y') }})</small>
                </div>
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
                <div class="chart-title">Pelanggan Repeat Order</div>
                <canvas id="topProductsChart1" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="col-xl-4 col-sm-4">
            <div class="chart-container">
                <div class="chart-title">Stok Menipis</div>
                <canvas id="topProductsChart2" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Sales -->
    <div class="row">
        <div class="col-12">
            <div class="recent-sales">
                <h5 class="mb-3">Transaksi Terbaru (7 Hari Terakhir)</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Tanggal</th>
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
    // Chart data from Laravel
    const chartData = @json($chartData);
    const recentSales = @json($recentSales);

    // Animate numbers
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

    // Format date for display
    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = { 
            weekday: 'short', 
            day: '2-digit', 
            month: 'short',
            timeZone: 'Asia/Jayapura'
        };
        return date.toLocaleDateString('id-ID', options);
    }

    // Initialize dashboard data
    window.addEventListener('load', function() {
        // Animate stats
        animateNumber(document.getElementById('totalSales'), `{{ $totalSales }}`);
        animateNumber(document.getElementById('totalRevenue'), `{{ $totalRevenue }}`);
        animateNumber(document.getElementById('totalProducts'), `{{ $totalProducts }}`);
        animateNumber(document.getElementById('lowStock'), `{{ $lowStock }}`);

        // Populate recent sales table
        recentSales.forEach(sale => {
            const row = document.createElement('tr');
            const statusClass = sale.status === 'lunas' ? 'success' : 'warning';
            const isToday = sale.date === '{{ Carbon\Carbon::today("Asia/Jayapura")->format("Y-m-d") }}';
            const dateDisplay = isToday ? 'Hari Ini' : formatDate(sale.date);
            
            row.innerHTML = `
                <td><strong>${sale.kode}</strong></td>
                <td>${sale.customer || 'N/A'}</td>
                <td>${sale.product}</td>
                <td>${sale.qty}</td>
                <td>Rp ${Number(sale.total).toLocaleString('id-ID')}</td>
                <td>${dateDisplay}</td>
                <td>${sale.time}</td>
                <td><span class="badge bg-${statusClass}">${sale.status}</span></td>
            `;
            document.getElementById('recentSalesTable').appendChild(row);
        });

        // Calculate max value for better Y-axis scaling
        const maxSales = Math.max(...chartData.salesData);
        const yAxisMax = maxSales > 0 ? Math.ceil(maxSales * 1.1) : 1000000;

        // Sales Chart - Enhanced for 7-day view
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Penjualan (Rp)',
                    data: chartData.salesData,
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#667eea',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: yAxisMax,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                                } else if (value >= 1000) {
                                    return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                                } else {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Tren Penjualan Harian',
                        font: {
                            size: 16
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        callbacks: {
                            label: function(context) {
                                return 'Penjualan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Top Products Chart
        const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
        new Chart(topProductsCtx, {
            type: 'doughnut',
            data: {
                labels: chartData.topProducts.labels,
                datasets: [{
                    data: chartData.topProducts.data,
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
                    },
                    title: {
                        display: true,
                        text: 'Produk Terlaris (30 Hari)'
                    }
                }
            }
        });

        // Repeat Customers Chart
        const repeatCustomersCtx = document.getElementById('topProductsChart1').getContext('2d');
        new Chart(repeatCustomersCtx, {
            type: 'pie',
            data: {
                labels: chartData.repeatCustomers.labels,
                datasets: [{
                    data: chartData.repeatCustomers.data,
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
                    },
                    title: {
                        display: true,
                        text: 'Pelanggan Repeat Order (30 Hari)'
                    }
                }
            }
        });

        // Low Stock Products Chart
        const lowStockCtx = document.getElementById('topProductsChart2').getContext('2d');
        new Chart(lowStockCtx, {
            type: 'doughnut',
            data: {
                labels: chartData.lowStockProducts.labels,
                datasets: [{
                    data: chartData.lowStockProducts.data,
                    backgroundColor: [
                        '#e74c3c',
                        '#f39c12',
                        '#ff6b6b',
                        '#ff9f43',
                        '#ee5a52'
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
                    },
                    title: {
                        display: true,
                        text: 'Stok Menipis'
                    }
                }
            }
        });
    });
</script>
@endpush