@extends('layouts.app')

@section('title', 'Buat Tiket Baru')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0">Buat Tiket Baru</h1>
                <p class="text-muted">Sampaikan keluhan atau pertanyaan Anda</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if (auth()->user()->isAdmin())
                                <h6>Pilih Nama User :</h6>
                                <div class="mb-3">
                                    <select name="id_user_create" class="form-select mb-3" required>
                                        <option value="">Pilih User</option>
                                        @foreach (\App\Models\User::whereHas('role', fn($q) => $q->whereIn('role_id', [3, 1]))->get() as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="id_kategori" class="form-label">Kategori <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('id_kategori') is-invalid @enderror" id="id_kategori"
                                    name="id_kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('id_kategori') == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Tiket <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    id="judul" name="judul" value="{{ old('judul') }}"
                                    placeholder="Contoh: Tidak bisa login ke sistem" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Lengkap <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="6"
                                    placeholder="Jelaskan masalah Anda secara detail..." required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="attachment" class="form-label">Lampiran (Opsional)</label>
                                <input type="file" class="form-control @error('attachment') is-invalid @enderror"
                                    id="attachment" name="attachment" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                <small class="text-muted">Format: JPG, PNG, PDF, atau File Pendukung Lain (Max: 2MB)</small>
                                @error('attachment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <span class="material-icons">send</span> Submit Tiket
                                </button>
                                <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
                                    <span class="material-icons">arrow_back</span> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-white"
                        style="background: linear-gradient(135deg, #1565C0, #1A2980); border-radius: 16px 16px 0 0;">
                        <h6 class="mb-0"><span class="material-icons">info</span> Informasi</h6>
                    </div>
                    <div class="card-body">
                        <h6>Tips Membuat Tiket:</h6>
                        <ul class="small">
                            <li>Gunakan judul yang jelas dan deskriptif</li>
                            <li>Jelaskan masalah secara detail</li>
                            <li>Lampirkan screenshot jika perlu</li>
                            <li>Sebutkan langkah yang sudah dicoba</li>
                        </ul>

                        <hr>

                        <h6>Proses Tiket:</h6>
                        <ol class="small">
                            <li>Tiket Anda akan direview oleh Admin</li>
                            <li>Admin akan assign ke Agent yang sesuai</li>
                            <li>Agent akan menghubungi Anda</li>
                            <li>Masalah akan diselesaikan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
