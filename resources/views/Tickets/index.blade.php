@extends('layouts.app')

@section('title', 'Daftar Tiket')

@section('content')
    <div class="container-fluid">
        <div class="row align-items-center mb-4">
            <div class="col-12 col-md-6">
                <h1 class="h3 mb-0">
                    @if (auth()->user()->isAdmin())
                        Semua Tiket
                    @else
                        Tiket Saya
                    @endif
                </h1>
                <p class="text-muted mb-0">Daftar tiket helpdesk</p>
            </div>
            @if (auth()->user()->isUser() || auth()->user()->isAdmin())
                <div class="col-12 col-md-6 d-flex flex-wrap gap-2 justify-content-md-end mt-3 mt-md-0">
                    @if (auth()->user()->isAdmin())
                        <button type="button" class="btn btn-success d-inline-flex align-items-center gap-1"
                            data-bs-toggle="modal" data-bs-target="#exportModal">
                            <span class="material-icons">file_download</span>Tarik Data
                        </button>
                    @endif
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-1">
                        <span class="material-icons">add_circle</span>Buat Tiket Baru
                    </a>
                </div>
            @endif
        </div>

        <div class="card">
            <div class="card-body">
                @if ($tickets->count() > 0)
                    <div class="table-responsive p-2 p-md-4">
                        <table id="ticketsTable" class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th width="80">No.</th>
                                    <th>Kode Tiket</th>
                                    <th style="min-width:180px">Judul</th>
                                    {{-- <th width="110">Lampiran</th> --}}
                                    <th width="150">Kategori</th>
                                    @if (auth()->user()->isAdmin())
                                        <th width="150">Pembuat</th>
                                        <th width="150">Agent</th>
                                    @endif
                                    <th width="120">Status</th>
                                    <th width="120">Dibuat</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td></td>
                                        <td><strong>{{ $ticket->kode_tiket ?? '-' }}</strong></td>
                                        <td>
                                            <strong>{{ $ticket->judul }}</strong>
                                            @if (auth()->user()->isAdmin() && $ticket->status == 'pending' && !$ticket->id_agent)
                                                <span class="badge bg-danger ms-2">Perlu Assign</span>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            @if ($ticket->attachment)
                                                <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank"
                                                    class="btn-action btn-action-lihat">
                                                    <span class="material-icons">attach_file</span> Lihat
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td> --}}
                                        <td>
                                            <span class="badge bg-secondary">{{ $ticket->category->nama_kategori }}</span>
                                        </td>
                                        @if (auth()->user()->isAdmin())
                                            <td>{{ $ticket->user->name }}</td>
                                            <td>
                                                @if ($ticket->agent)
                                                    {{ $ticket->agent->name }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        @endif
                                        <td>
                                            <span class="badge {{ $ticket->getStatusBadgeClass() }}">
                                                {{ $ticket->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td>{{ $ticket->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('tickets.show', $ticket->id_tiket) }}"
                                                class="btn-action btn-action-lihat">
                                                <span class="material-icons">visibility</span> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <span class="material-icons" style="font-size: 4rem; color: #ccc;">inbox</span>
                        <p class="text-muted mt-3 mb-0">Belum ada tiket</p>
                        @if (auth()->user()->isUser() || auth()->user()->isAdmin())
                            <a href="{{ route('tickets.create') }}" class="btn btn-primary mt-3">
                                <span class="material-icons">add_circle</span>Buat Tiket Pertama
                            </a>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>

    @if (auth()->user()->isAdmin())
        <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="GET" action="{{ route('tickets.export') }}">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exportModalLabel">Tarik Data Tiket</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-muted small">
                                Atur filter di bawah lalu unduh data tiket. Kosongkan filter untuk menarik semua data.
                            </p>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="{{ \App\Models\Tiket::STATUS_PENDING }}">Menunggu Persetujuan</option>
                                    <option value="{{ \App\Models\Tiket::STATUS_APPROVED }}">Disetujui</option>
                                    <option value="{{ \App\Models\Tiket::STATUS_IN_PROGRESS }}">Sedang Dikerjakan</option>
                                    <option value="{{ \App\Models\Tiket::STATUS_CONFIRM }}">Konfirmasi User</option>
                                    <option value="{{ \App\Models\Tiket::STATUS_COMPLETED }}">Selesai</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Dari Tanggal</label>
                                <input type="date" class="form-control" id="start_date" name="start_date">
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Sampai Tanggal</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary d-inline-flex align-items-center gap-1"
                                data-bs-dismiss="modal">
                                <span class="material-icons">close</span> Batal
                            </button>
                            <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-1">
                                <span class="material-icons">file_download</span> Download Excel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($tickets->count() > 0)
        @push('scripts')
            <script>
                $(function() {
                    $('#ticketsTable').DataTable({
                        responsive: true,
                        order: [
                            [{{ auth()->user()->isAdmin() ? 8 : 6 }}, 'desc']
                        ],
                        columnDefs: [{
                                targets: 0,
                                orderable: false
                            },
                            {
                                targets: 3,
                                orderable: false
                            }
                        ],
                        drawCallback: function() {
                            var api = this.api();
                            var start = api.page.info().start;
                            api.column(0, {
                                page: 'current'
                            }).nodes().each(function(cell, i) {
                                $(cell).html(start + i + 1);
                            });
                        },
                        language: {
                            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                        }
                    });
                });
            </script>
        @endpush
    @endif

@endsection
