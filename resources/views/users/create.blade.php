@extends('layouts.app')

@section('title', 'Tambah User Baru')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0">Tambah User Baru</h1>
                <p class="text-muted">Buat akun user baru dalam sistem</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select @error('role_id') is-invalid @enderror" id="role_id"
                                    name="role_id" required>
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ $role->display_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                <small class="text-muted">Minimal 8 karakter</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <span class="material-icons">save</span> Simpan User
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                    <span class="material-icons">arrow_back</span> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #1565C0, #1A2980); border-radius: 16px 16px 0 0;">
                        <h6 class="mb-0"><span class="material-icons">info</span> Informasi Role</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Admin:</strong>
                            <ul class="small mb-0">
                                <li>Akses penuh ke sistem</li>
                                <li>Kelola user & ticket</li>
                                <li>Assign ticket ke agent</li>
                            </ul>
                        </div>
                        <div class="mb-3">
                            <strong>Agent:</strong>
                            <ul class="small mb-0">
                                <li>Handle ticket yang di-assign</li>
                                <li>Reply & resolve ticket</li>
                            </ul>
                        </div>
                        <div>
                            <strong>User:</strong>
                            <ul class="small mb-0">
                                <li>Buat ticket baru</li>
                                <li>Lihat & reply ticket sendiri</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
