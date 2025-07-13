<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Point of Sales</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
            --navbar-height: 60px;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            height: var(--navbar-height);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }
        
        .sidebar {
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            height: calc(100vh - var(--navbar-height));
            width: var(--sidebar-width);
            background: #2c3e50;
            transition: all 0.3s ease;
            overflow-y: auto;
            z-index: 1020;
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #34495e;
        }
        
        .sidebar-header h5 {
            color: #ecf0f1;
            margin: 0;
            font-size: 1.1rem;
        }
        
        .sidebar.collapsed .sidebar-header h5 {
            display: none;
        }
        
        .sidebar-menu {
            padding: 0;
            list-style: none;
        }
        
        .sidebar-menu li {
            border-bottom: 1px solid #34495e;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #34495e;
            color: #3498db;
        }
        
        .sidebar-menu i {
            width: 20px;
            margin-right: 10px;
            text-align: center;
        }

        .sidebar.collapsed .sidebar-menu i {
            margin-right: 0px !important;
        }
        
        .sidebar.collapsed .sidebar-menu span {
            display: none;
        }
        
        .sidebar.collapsed .sidebar-menu a {
            justify-content: center;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 20px;
            transition: margin-left 0.3s ease;
        }
        
        .main-content.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }
        
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        
        .stats-card.primary .icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .stats-card.success .icon {
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            color: white;
        }
        
        .stats-card.warning .icon {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
        }
        
        .stats-card.danger .icon {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }
        
        .stats-card h3 {
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
            color: #2c3e50;
        }
        
        .stats-card p {
            margin: 0;
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        .chart-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .chart-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        
        .recent-sales {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .toggle-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        
        .toggle-btn:hover {
            color: #3498db;
        }
        
        .datetime-display {
            color: white;
            font-size: 0.9rem;
        }
        
        .navbar-brand {
            color: white !important;
            font-weight: bold;
        }
        
        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: var(--sidebar-collapsed-width);
            }
            
            .main-content {
                margin-left: var(--sidebar-collapsed-width);
            }
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="toggle-btn me-3" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>
            
            <a class="navbar-brand" href="#">
                <i class="fas fa-cash-register me-2"></i>
                Point of Sales
            </a>
            
            <div class="ms-auto d-flex align-items-center">
                <div class="datetime-display me-3" id="currentDateTime">
                    Loading...
                </div>
                
                <div class="dropdown">
                    <button class="btn btn-link text-white dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-2"></i>
                        Admin
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h5>Menu</h5>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="#" class="active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Penjualan</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-box"></i>
                    <span>Produk</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-users"></i>
                    <span>Pelanggan</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-warehouse"></i>
                    <span>Inventaris</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-receipt"></i>
                    <span>Transaksi</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
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
                
                <div class="col-xl-4">
                    <div class="chart-container">
                        <div class="chart-title">Produk Terlaris</div>
                        <canvas id="topProductsChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="chart-container">
                        <div class="chart-title">Produk Terlaris</div>
                        <canvas id="topProductsChart1" width="400" height="200"></canvas>
                    </div>
                </div>

                <div class="col-xl-4">
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
                                        <th>ID Transaksi</th>
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
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // Toggle Sidebar
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        // Indonesian DateTime
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                timeZone: 'Asia/Jakarta'
            };
            
            const indonesianDateTime = new Intl.DateTimeFormat('id-ID', options).format(now);
            document.getElementById('currentDateTime').textContent = indonesianDateTime + ' WIB';
        }

        // Update datetime every second
        setInterval(updateDateTime, 1000);
        updateDateTime();

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

            // Populate recent sales table
            const recentSales = [
                { id: 'TRX001', customer: 'Budi Santoso', product: 'Smartphone Samsung', qty: 1, total: 3500000, time: '10:30', status: 'Selesai' },
                { id: 'TRX002', customer: 'Siti Nurhaliza', product: 'Laptop Asus', qty: 1, total: 7200000, time: '11:15', status: 'Proses' },
                { id: 'TRX003', customer: 'Ahmad Rizki', product: 'Headphone Sony', qty: 2, total: 850000, time: '12:00', status: 'Selesai' },
                { id: 'TRX004', customer: 'Maya Sari', product: 'Tablet iPad', qty: 1, total: 4500000, time: '13:45', status: 'Selesai' },
                { id: 'TRX005', customer: 'Doni Pratama', product: 'Speaker JBL', qty: 1, total: 1200000, time: '14:20', status: 'Proses' }
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
</body>
</html>