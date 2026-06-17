@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0">Tambah FAQ</h1>
                <p class="text-muted">Buat FAQ baru</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('faq.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- KATEGORI -->
                            <div class="mb-3">
                                <label>Kategori</label>
                                <select name="kategori_id" class="form-select">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('kategori_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- PERTANYAAN -->
                            <div class="mb-3">
                                <label>Pertanyaan</label>
                                <input type="text" name="question" class="form-control" value="{{ old('question') }}"
                                    placeholder="Masukkan pertanyaan (max 255 karakter)">
                            </div>

                            <!-- JAWABAN -->
                            <div class="mb-3">
                                <label>Jawaban <small class="text-muted">(opsional)</small></label>
                                <textarea name="answer" id="answer" class="form-control">{{ old('answer') }}</textarea>
                            </div>

                            <!-- FILE -->
                            <div class="mb-3">
                                <label>File Jawaban <small class="text-muted">(opsional, PNG / PDF max 2MB)</small></label>
                                <input type="file" name="file" class="form-control" accept=".png,.jpg,.jpeg,.pdf">

                                <small class="text-muted">
                                    Hanya file PNG, JPG, PDF. Maksimal 2MB.
                                </small>
                            </div>

                            <!-- STATUS -->
                            <div class="mb-3">
                                <label>Status</label>
                                <input type="text" class="form-control" value="Nonaktif (default)" disabled>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <span class="material-icons">save</span> Simpan
                                </button>
                                <a href="{{ route('faq.index') }}" class="btn btn-secondary">
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
                        <h6 class="mb-0"><span class="material-icons">info</span> Informasi</h6>
                    </div>
                    <div class="card-body">
                        <h6>Tips Membuat FAQ:</h6>
                        <ul class="small">
                            <li>Gunakan pertanyaan yang jelas dan singkat</li>
                            <li>Pilih kategori yang paling sesuai</li>
                            <li>Upload file jika jawaban berupa gambar atau dokumen</li>
                            <li>FAQ baru otomatis berstatus <strong>Nonaktif</strong></li>
                        </ul>

                        <hr>

                        <h6>Status FAQ:</h6>
                        <ol class="small">
                            <li>FAQ dibuat dengan status <strong>Nonaktif</strong></li>
                            <li>Edit FAQ lalu centang <strong>Aktifkan</strong> untuk menampilkan ke user</li>
                            <li>FAQ aktif akan tampil di halaman FAQ user</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <script>
            ClassicEditor.create(document.querySelector('#answer')).catch(console.error);
        </script>
    @endpush

@endsection
