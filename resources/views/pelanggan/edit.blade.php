@extends('dasbor')

@section('content')
<div class="container-fluid">
        <h1>Edit Pelanggan</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('pelanggans.update', $pelanggan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $pelanggan->nama) }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $pelanggan->email) }}">
            </div>
            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon', $pelanggan->telepon) }}">
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat', $pelanggan->alamat) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                    <option value="">Pilih</option>
                    <option value="L" {{ old('jenis_kelamin', $pelanggan->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $pelanggan->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $pelanggan->tanggal_lahir) }}">
            </div>
            <div class="mb-3">
                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="{{ old('pekerjaan', $pelanggan->pekerjaan) }}">
            </div>
            <div class="mb-3">
                <label for="no_ktp" class="form-label">No. KTP</label>
                <input type="text" name="no_ktp" id="no_ktp" class="form-control" value="{{ old('no_ktp', $pelanggan->no_ktp) }}">
            </div>
            <div class="mb-3">
                <label for="status_aktif" class="form-label">Status Aktif</label>
                <select name="status_aktif" id="status_aktif" class="form-control">
                    <option value="1" {{ old('status_aktif', $pelanggan->status_aktif) ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status_aktif', $pelanggan->status_aktif) ? '' : 'selected' }}>Non-Aktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection