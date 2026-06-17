@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0">Tambah Kategori</h1>
                <p class="text-muted">Buat kategori ticket baru</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nama_kategori" class="form-label">Nama Kategori <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                                    id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}"
                                    placeholder="Contoh: Technical Support" required>
                                @error('nama_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <span class="material-icons">save</span> Simpan Kategori
                                </button>
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
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
                        <h6 class="mb-0"><span class="material-icons">info</span> Panduan</h6>
                    </div>
                    <div class="card-body">
                        <h6>Tips Membuat Kategori:</h6>
                        <ul class="small">
                            <li>Kelompokkan tiket berdasarkan jenis kebutuhan atau masalah</li>
                            <li>Gunakan nama kategori yang singkat dan mudah dipahami</li>
                            <li>Pilih kategori yang dapat digunakan untuk banyak tiket sejenis</li>
                            <li>Hindari membuat kategori yang terlalu spesifik</li>
                        </ul>
                        <hr>
                        <h6>Contoh Kategori:</h6>
                        <ul class="small">
                            <li>Troubleshooting</li>
                            <li>Permintaan Layanan (Request)</li>
                            <li>Hardware</li>
                            <li>Maintenance</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
