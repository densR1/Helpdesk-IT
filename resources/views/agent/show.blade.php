@extends('layouts.app')

@section('title', 'Detail Tiket')

@section('content')
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0">Detail Tiket</h1>
                <p class="text-muted">{{ $tiket->kode_tiket ?? '-' }}</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('agent.tickets') }}" class="btn btn-secondary">
                    <span class="material-icons">arrow_back</span> Kembali
                </a>
            </div>
        </div>

        {{-- Main Info --}}
        <div class="card mb-4">
            <div class="card-header text-white"
                style="background: linear-gradient(135deg, #1565C0, #1A2980); border-radius: 16px 16px 0 0;">
                <strong>{{ $tiket->judul }}</strong>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">

                    {{-- Kiri: Lampiran --}}
                    <div class="col-md-4">
                        <div class="attachment-preview-box">
                            @if ($tiket->attachment)
                                @php $ext = strtolower(pathinfo($tiket->attachment, PATHINFO_EXTENSION)); @endphp
                                @if ($ext === 'pdf')
                                    <div class="file-icon-box"
                                        style="background: linear-gradient(135deg, #c62828, #e53935);">
                                        <span class="material-icons"
                                            style="font-size: 4rem; color: #fff;">picture_as_pdf</span>
                                        <span class="file-ext-label">PDF</span>
                                    </div>
                                @elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    <div class="file-icon-box"
                                        style="background: linear-gradient(135deg, #1565C0, #1A2980);">
                                        <span class="material-icons" style="font-size: 4rem; color: #fff;">image</span>
                                        <span class="file-ext-label">{{ strtoupper($ext) }}</span>
                                    </div>
                                @else
                                    <div class="file-icon-box"
                                        style="background: linear-gradient(135deg, #546e7a, #37474f);">
                                        <span class="material-icons"
                                            style="font-size: 4rem; color: #fff;">description</span>
                                        <span class="file-ext-label">{{ strtoupper($ext) }}</span>
                                    </div>
                                @endif
                                <a href="{{ asset('storage/' . $tiket->attachment) }}" target="_blank"
                                    class="btn-action btn-action-lihat w-100 justify-content-center mt-3">
                                    <span class="material-icons">visibility</span> Lihat Lampiran
                                </a>
                            @else
                                <div class="no-attachment-box">
                                    <span class="material-icons" style="font-size: 3rem; color: #cbd5e1;">attach_file</span>
                                    <p class="text-muted mt-2 mb-0 small">Tidak ada lampiran</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Kanan: Info --}}
                    <div class="col-md-8">
                        <table class="table table-borderless detail-table">
                            <tbody>
                                <tr>
                                    <th style="width:140px">Kode Tiket</th>
                                    <td>: <strong>{{ $tiket->kode_tiket ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Pembuat</th>
                                    <td>: {{ $tiket->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>: <span class="badge bg-secondary">{{ $tiket->category->nama_kategori }}</span></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>: <span
                                            class="badge {{ $tiket->getStatusBadgeClass() }}">{{ $tiket->getStatusLabel() }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>: {{ $tiket->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="align-top">Deskripsi</th>
                                    <td>: {!! nl2br(e($tiket->deskripsi)) !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        {{-- Update Status --}}
        @if ($tiket->status != \App\Models\Tiket::STATUS_COMPLETED)
            <div class="card mb-4">
                <div class="card-header text-white"
                    style="background: linear-gradient(135deg, #1565C0, #1A2980); border-radius: 16px 16px 0 0;">
                    <strong><span class="material-icons">edit</span> Ubah Status Tiket</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('agent.tickets.updateStatus', $tiket->id_tiket) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="1" {{ $tiket->status === 1 ? 'selected' : '' }}>Disetujui</option>
                                    <option value="2" {{ $tiket->status === 2 ? 'selected' : '' }}>Sedang Dikerjakan
                                    </option>
                                    <option value="3" {{ $tiket->status === 3 ? 'selected' : '' }}>Konfirmasi</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary w-100">
                                    <span class="material-icons">save</span> Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- Komentar --}}
        <div class="card">
            <div class="card-header text-white"
                style="background: linear-gradient(135deg, #1565C0, #1A2980); border-radius: 16px 16px 0 0;">
                <strong><span class="material-icons">chat</span> Komentar</strong>
            </div>
            <div class="card-body">

                <div class="comments-list mb-4">
                    @forelse($tiket->comments as $c)
                        <div class="comment-item">
                            <div class="comment-avatar">{{ strtoupper(substr($c->user->name, 0, 1)) }}</div>
                            <div class="comment-body">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <strong>{{ $c->user->name }}</strong>
                                    <span class="text-muted"
                                        style="font-size:12px;">{{ $c->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="mb-1">{{ $c->komentar }}</p>
                                @if ($c->attachment)
                                    @php $ext = strtolower(pathinfo($c->attachment, PATHINFO_EXTENSION)); @endphp
                                    @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                        <img src="{{ asset('storage/' . $c->attachment) }}"
                                            class="img-fluid mt-2 rounded-2" style="max-height:180px;">
                                    @else
                                        <a href="{{ asset('storage/' . $c->attachment) }}" target="_blank"
                                            class="btn-action btn-action-lihat mt-2 d-inline-flex">
                                            <span class="material-icons">visibility</span> Lihat File
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-3">Belum ada komentar</p>
                    @endforelse
                </div>

                <form action="{{ route('agent.tickets.addComment', $tiket->id_tiket) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <textarea name="komentar" class="form-control mb-2" rows="3" placeholder="Tulis komentar..." required></textarea>
                    <input type="file" name="attachment" class="form-control mb-3"
                        accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                    <button class="btn btn-primary">
                        <span class="material-icons">send</span> Kirim Komentar
                    </button>
                </form>

            </div>
        </div>

    </div>

    @push('styles')
        <style>
            .attachment-preview-box {
                background: #f8fafc;
                border: 2px dashed #e2e8f0;
                border-radius: 16px;
                padding: 24px;
                text-align: center;
                min-height: 200px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .file-icon-box {
                width: 150px;
                height: 170px;
                border-radius: 20px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 8px;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            }

            .file-ext-label {
                color: #fff;
                font-size: 1rem;
                font-weight: 700;
                letter-spacing: 1px;
            }

            .no-attachment-box {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 24px 0;
            }

            .detail-table th {
                color: #64748b;
                font-weight: 600;
                padding: 10px 8px;
                border-bottom: 1px solid #f1f5f9;
            }

            .detail-table td {
                padding: 10px 8px;
                border-bottom: 1px solid #f1f5f9;
                color: #1e293b;
            }

            .detail-table tr:last-child th,
            .detail-table tr:last-child td {
                border-bottom: none;
            }

            .comments-list {
                display: flex;
                flex-direction: column;
                gap: 16px;
            }

            .comment-item {
                display: flex;
                gap: 12px;
                background: #f8fafc;
                border-radius: 12px;
                padding: 14px;
            }

            .comment-avatar {
                width: 38px;
                height: 38px;
                min-width: 38px;
                border-radius: 50%;
                background: linear-gradient(135deg, #1565C0, #1A2980);
                color: #fff;
                font-weight: 700;
                font-size: 0.9rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .comment-body {
                flex: 1;
            }
        </style>
    @endpush

@endsection
