@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0">Edit FAQ</h1>
                <p class="text-muted">Perbarui pertanyaan & jawaban</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('faq.update', $faq->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- KATEGORI -->
                            <div class="mb-3">
                                <label>Kategori</label>
                                <select name="kategori_id" class="form-select">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $faq->kategori_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- PERTANYAAN -->
                            <div class="mb-3">
                                <label>Pertanyaan</label>
                                <input type="text" name="question" value="{{ old('question', $faq->question) }}" class="form-control"
                                    placeholder="Masukkan pertanyaan (max 255 karakter)">
                            </div>

                            <!-- JAWABAN -->
                            <div class="mb-3">
                                <label>Jawaban <small class="text-muted">(opsional)</small></label>
                                <textarea name="answer" id="answer" class="form-control">{{ old('answer', $faq->answer) }}</textarea>
                            </div>

                            <!-- FILE -->
                            <div class="mb-3">
                                <label>File Jawaban <small class="text-muted">(opsional, PNG / PDF max 2MB)</small></label>
                                <input type="file" name="file" class="form-control" accept=".png,.jpg,.jpeg,.pdf">

                                <small class="text-muted">
                                    Hanya file PNG, JPG, PDF. Maksimal 2MB.
                                </small>

                                @if ($faq->file)
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $faq->file) }}" target="_blank"
                                            class="btn-action btn-action-lihat">
                                            <span class="material-icons">description</span> Lihat File Saat Ini
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <!-- STATUS -->
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="is_active" class="form-select">
                                    <option value="0" {{ !$faq->is_active ? 'selected' : '' }}>Nonaktif</option>
                                    <option value="1" {{ $faq->is_active ? 'selected' : '' }}>Aktif</option>
                                </select>
                            </div>

                            <button class="btn btn-primary">Update</button>

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
                        <h6>Panduan Edit FAQ:</h6>
                        <ul class="small">
                            <li>Biarkan kolom file kosong jika tidak ingin mengganti file</li>
                            <li>Upload file baru untuk mengganti file lama</li>
                            <li>Centang <strong>Aktifkan FAQ</strong> agar tampil ke user</li>
                        </ul>

                        <hr>

                        <h6>Status FAQ:</h6>
                        <ol class="small">
                            <li>FAQ <strong>Nonaktif</strong> tidak tampil ke user</li>
                            <li>FAQ <strong>Aktif</strong> tampil di halaman FAQ user</li>
                            <li>Nonaktifkan jika FAQ perlu direvisi ulang</li>
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
