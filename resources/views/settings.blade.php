@extends('dasbor')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Password Change Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4><i class="fas fa-lock me-2"></i>Ganti Password</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('settings.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password"
                                    name="current_password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password"
                                    name="new_password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Minimal 8 karakter</small>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password_confirmation"
                                    name="new_password_confirmation" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password_confirmation')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Ganti Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Notification Settings Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4><i class="fas fa-bell me-2"></i>Pengaturan Notifikasi</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.notifications') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="email_notifications"
                                    name="email_notifications" {{ auth()->user()->email_notifications ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_notifications">
                                    <i class="fas fa-envelope me-2"></i>Notifikasi Email
                                </label>
                                <small class="d-block text-muted">Terima notifikasi melalui email</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="push_notifications"
                                    name="push_notifications" {{ auth()->user()->push_notifications ? 'checked' : '' }}>
                                <label class="form-check-label" for="push_notifications">
                                    <i class="fas fa-mobile-alt me-2"></i>Notifikasi Push
                                </label>
                                <small class="d-block text-muted">Terima notifikasi push di browser</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sms_notifications"
                                    name="sms_notifications" {{ auth()->user()->sms_notifications ? 'checked' : '' }}>
                                <label class="form-check-label" for="sms_notifications">
                                    <i class="fas fa-sms me-2"></i>Notifikasi SMS
                                </label>
                                <small class="d-block text-muted">Terima notifikasi melalui SMS</small>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Info Section -->
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-info-circle me-2"></i>Informasi Akun</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
                            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                            <p><strong>Bergabung:</strong> {{ auth()->user()->created_at->format('d F Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong>
                                <span class="badge bg-success">Aktif</span>
                            </p>
                            <p><strong>Terakhir Login:</strong>
                                {{ auth()->user()->last_login ? auth()->user()->last_login->format('d F Y H:i') : 'Belum pernah login' }}
                            </p>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <a href="{{ route('profile') }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.nextElementSibling.querySelector('i');

        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection