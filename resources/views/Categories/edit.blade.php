@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0">Edit Kategori</h1>
                <p class="text-muted">Update kategori ticket</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('categories.update', $category) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nama_kategori" class="form-label">Nama Kategori <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                                    id="nama_kategori" name="nama_kategori"
                                    value="{{ old('nama_kategori', $category->nama_kategori) }}" required>
                                @error('nama_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-info">
                                <span class="material-icons">info</span>
                                Kategori ini memiliki <strong>{{ $category->tiket()->count() }} tiket</strong>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <span class="material-icons">save</span> Update Kategori
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
                        <h6>Tips Edit Kategori:</h6>
                        <ul class="small">
                            <li>Pastikan nama baru masih relevan dengan tiket yang sudah ada</li>
                            <li>Perubahan nama akan langsung berlaku pada semua tiket di kategori ini</li>
                            <li>Gunakan nama yang singkat dan mudah dipahami</li>
                        </ul>
                        <hr>
                        <h6>Perhatian:</h6>
                        <ul class="small">
                            <li>Kategori yang memiliki tiket <strong>tidak dapat dihapus</strong></li>
                            <li>Hapus atau pindahkan tiket terlebih dahulu sebelum menghapus kategori</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
