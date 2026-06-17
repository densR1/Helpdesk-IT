@extends('layouts.app')

@section('title', 'Detail Tiket')

@section('content')
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0">Detail Tiket</h1>
                <p class="text-muted">{{ $ticket->kode_tiket ?? '-' }}</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
                    <span class="material-icons">arrow_back</span> Kembali
                </a>
            </div>
        </div>

        {{-- Main Info --}}
        <div class="card mb-4">
            <div class="card-header text-white"
                style="background: linear-gradient(135deg, #1565C0, #1A2980); border-radius: 16px 16px 0 0;">
                <strong>{{ $ticket->judul }}</strong>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">

                    {{-- Kiri: Lampiran --}}
                    <div class="col-md-4">
                        <div class="attachment-preview-box">
                            @if ($ticket->attachment)
                                @php $ext = strtolower(pathinfo($ticket->attachment, PATHINFO_EXTENSION)); @endphp
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
                                <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank"
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
                                    <td>: <strong>{{ $ticket->kode_tiket ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <th>User</th>
                                    <td>: {{ $ticket->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>: <span class="badge bg-secondary">{{ $ticket->category->nama_kategori }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>: <span
                                            class="badge {{ $ticket->getStatusBadgeClass() }}">{{ $ticket->getStatusLabel() }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Agent</th>
                                    <td>:
                                        @if ($ticket->agent)
                                            {{ $ticket->agent->name }}
                                        @else
                                            <span class="text-danger">Belum ditunjuk</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>: {{ $ticket->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="align-top">Deskripsi</th>
                                    <td>: {{ $ticket->deskripsi }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        {{-- Assign Agent (Admin) --}}
        @if (auth()->user()->isAdmin() && $ticket->isPending())
            <div class="card mb-4">
                <div class="card-header text-white"
                    style="background: linear-gradient(135deg, #1565C0, #1A2980); border-radius: 16px 16px 0 0;">
                    <strong><span class="material-icons">assignment_ind</span> Assign Agent</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('tickets.assignAgent', $ticket->id_tiket) }}" method="POST">
                        @csrf
                        <div class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <label class="form-label">Pilih Agent</label>
                                <select name="id_agent" class="form-select" required>
                                    <option value="">-- Pilih Agent --</option>
                                    @foreach (\App\Models\User::whereHas('role', fn($q) => $q->where('name', 'agent'))->get() as $agent)
                                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <span class="material-icons">send</span> Assign
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- Update Status (Admin / Agent) --}}
        @if ((auth()->user()->isAgent() && $ticket->id_agent === auth()->id()) || auth()->user()->isAdmin())
            <div class="card mb-4">
                <div class="card-header text-white"
                    style="background: linear-gradient(135deg, #1565C0, #1A2980); border-radius: 16px 16px 0 0;">
                    <strong><span class="material-icons">edit</span> Ubah Status Tiket</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('tickets.updateStatus', $ticket->id_tiket) }}" method="POST">
                        @csrf
                        <div class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="{{ \App\Models\Tiket::STATUS_PENDING }}"
                                        {{ $ticket->status == \App\Models\Tiket::STATUS_PENDING ? 'selected' : '' }}>
                                        Menunggu Persetujuan</option>
                                    <option value="{{ \App\Models\Tiket::STATUS_APPROVED }}"
                                        {{ $ticket->status == \App\Models\Tiket::STATUS_APPROVED ? 'selected' : '' }}>
                                        Disetujui</option>
                                    <option value="{{ \App\Models\Tiket::STATUS_IN_PROGRESS }}"
                                        {{ $ticket->status == \App\Models\Tiket::STATUS_IN_PROGRESS ? 'selected' : '' }}>
                                        Sedang Dikerjakan</option>
                                    <option value="{{ \App\Models\Tiket::STATUS_CONFIRM }}"
                                        {{ $ticket->status == \App\Models\Tiket::STATUS_CONFIRM ? 'selected' : '' }}>
                                        Konfirmasi</option>
                                    <option value="{{ \App\Models\Tiket::STATUS_COMPLETED }}"
                                        {{ $ticket->status == \App\Models\Tiket::STATUS_COMPLETED ? 'selected' : '' }}>
                                        Selesai</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <span class="material-icons">save</span> Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- Konfirmasi Selesai (User) --}}
        @if ($ticket->isConfirm() && $ticket->id_user_create === auth()->id())
            <div class="card mb-4">
                <div class="card-body">
                    <p class="mb-2">Tiket sudah selesai dikerjakan. Harap cek kembali dan konfirmasi.</p>
                    <form action="{{ route('tickets.confirm', $ticket->id_tiket) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <span class="material-icons">check_circle</span> Konfirmasi Selesai
                        </button>
                    </form>
                    <p class="small text-muted mt-2"><span class="text-danger">*</span> Setelah konfirmasi, sesi tiket akan
                        ditutup.</p>
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
                    @forelse($ticket->comments as $c)
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

                @if (auth()->user()->isUser())
                    @if ($ticket->isPending())
                        <div class="alert alert-secondary d-flex align-items-center gap-2 mb-0" role="alert">
                            <span class="material-icons">lock</span>
                            <span>Komentar belum tersedia. Agent Belum ditunjuk.</span>
                        </div>
                    @else
                        <form action="{{ route('tickets.addComment', $ticket->id_tiket) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <textarea name="komentar" class="form-control mb-2" rows="3" placeholder="Tulis komentar..." required></textarea>
                            <input type="file" name="attachment" class="form-control mb-3"
                                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                            <button class="btn btn-primary">
                                <span class="material-icons">send</span> Kirim Komentar
                            </button>
                        </form>
                    @endif
                @endif

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
