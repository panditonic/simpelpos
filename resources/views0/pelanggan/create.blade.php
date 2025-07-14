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
            <a href="{{ route('pelanggans.index') }}" class="btn btn-success btn-sm">Kembali</a>
        </div>
    </div>
    <!-- Konten lainnya -->

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('pelanggans.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon') }}">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                <option value="">Pilih</option>
                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
        </div>
        <div class="mb-3">
            <label for="pekerjaan" class="form-label">Pekerjaan</label>
            <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="{{ old('pekerjaan') }}">
        </div>
        <div class="mb-3">
            <label for="no_ktp" class="form-label">No. KTP</label>
            <input type="text" name="no_ktp" id="no_ktp" class="form-control" value="{{ old('no_ktp') }}">
        </div>
        <div class="mb-3">
            <label for="status_aktif" class="form-label">Status Aktif</label>
            <select name="status_aktif" id="status_aktif" class="form-control">
                <option value="1" {{ old('status_aktif') == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('status_aktif') == '0' ? 'selected' : '' }}>Non-Aktif</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection