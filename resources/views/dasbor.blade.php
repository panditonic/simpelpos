<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Point of Sales</title>
    <!-- In <head> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="https://img.icons8.com/?size=100&id=g1VKFeZ7mFa2&format=png&color=000000">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    @stack('styles')

    <link rel="stylesheet" href="{{ asset('default.css') }}">
</head>

<body>
    <!-- Sidebar Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="toggle-btn me-3" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>

            <a class="navbar-brand" href="/dasbor">
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
                        <span id="userAktif">User Aktif</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/profile"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="/settings"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="confirmLogout()">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
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
                <a href="/dasbor" class="active">
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
                <a href="/produks">
                    <i class="fas fa-box"></i>
                    <span>Produk</span>
                </a>
            </li>
            <li>
                <a href="/pelanggans">
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
            <!-- <li>
                <a href="#">
                    <i class="fas fa-warehouse"></i>
                    <span>Inventaris</span>
                </a>
            </li> -->
            <!-- <li>
                <a href="#">
                    <i class="fas fa-receipt"></i>
                    <span>Transaksi</span>
                </a>
            </li> -->
            <!-- <li>
                <a href="#">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </a>
            </li> -->
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        @yield('content','halaman tidak tersedia')

        <!-- Footer (visible on mobile/tablet) -->
        <footer class="footer">
            <div id="footerDateTime">
                Loading...
            </div>
        </footer>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.all.min.js"></script>
        
        <script>
            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Session management
            function checkSession() {
                fetch('/check-auth', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        $('#userAktif').text(data.user.name)
                    })
                    .catch(error => {
                        console.error('Error checking session:', error);
                    });
            }

            // Check for existing session on page load
            document.addEventListener('DOMContentLoaded', function() {
                checkSession();
            });

            // Enhanced Toggle Sidebar with responsive support
            document.getElementById('toggleSidebar').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('mainContent');
                const overlay = document.getElementById('sidebarOverlay');

                // Check if we're in responsive mode
                const isResponsive = window.innerWidth <= 768;

                if (isResponsive) {
                    // Mobile behavior
                    if (sidebar.classList.contains('force-expanded')) {
                        // Close sidebar
                        sidebar.classList.remove('force-expanded');
                        mainContent.classList.remove('force-contracted');
                        overlay.classList.remove('show');
                    } else {
                        // Open sidebar
                        sidebar.classList.add('force-expanded');
                        mainContent.classList.add('force-contracted');
                        overlay.classList.add('show');
                    }
                } else {
                    // Desktop behavior
                    if (sidebar.classList.contains('collapsed')) {
                        // Expand sidebar
                        sidebar.classList.remove('collapsed');
                        mainContent.classList.remove('expanded');
                    } else {
                        // Collapse sidebar
                        sidebar.classList.add('collapsed');
                        mainContent.classList.add('expanded');
                    }
                }
            });

            // Close sidebar when clicking overlay
            document.getElementById('sidebarOverlay').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('mainContent');
                const overlay = document.getElementById('sidebarOverlay');

                sidebar.classList.remove('force-expanded');
                mainContent.classList.remove('force-contracted');
                overlay.classList.remove('show');
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('mainContent');
                const overlay = document.getElementById('sidebarOverlay');

                if (window.innerWidth > 768) {
                    // Desktop - remove mobile classes
                    sidebar.classList.remove('force-expanded');
                    mainContent.classList.remove('force-contracted');
                    overlay.classList.remove('show');
                }
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
                    timeZone: 'Asia/Jayapura'
                };

                const indonesianDateTime = new Intl.DateTimeFormat('id-ID', options).format(now);
                const formattedTime = indonesianDateTime + ' WIB';

                // Update both navbar and footer datetime
                document.getElementById('currentDateTime').textContent = formattedTime;
                document.getElementById('footerDateTime').textContent = formattedTime;
            }

            // Update datetime every second
            setInterval(updateDateTime, 1000);
            updateDateTime();

            // SweetAlert Logout Confirmation
            function confirmLogout() {
                Swal.fire({
                    title: 'Konfirmasi Logout',
                    text: 'Apakah Anda yakin ingin keluar dari sistem?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Logout!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Logging out...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Perform logout
                        $.ajax({
                            url: '{{ route("logout") }}',
                            type: 'POST',
                            data: {
                                _token: csrfToken
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil Logout!',
                                    text: 'Anda akan dialihkan ke halaman login',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = '/login';
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat logout. Silakan coba lagi.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            }
        </script>

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

        @stack('scripts')
</body>

</html>