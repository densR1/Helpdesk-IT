@extends('layouts.app')

@section('title', 'Tiket Ditugaskan Kepada Saya')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0">Tiket Ditugaskan Kepada Saya</h1>
                <p class="text-muted">Daftar tiket yang perlu ditangani</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive p-2 p-md-4">
                    <table id="tiket-table" class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:5%">No</th>
                                <th>Judul</th>
                                <th style="width:15%">Kode Tiket</th>
                                <th style="width:15%">Kategori</th>
                                <th style="width:15%">Pembuat</th>
                                <th style="width:12%">Status</th>
                                <th style="width:10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tiket as $t)
                                <tr>
                                    <td></td>
                                    <td><strong>{{ $t->judul }}</strong></td>
                                    <td>{{ $t->kode_tiket ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $t->category->nama_kategori ?? '-' }}</span>
                                    </td>
                                    <td>{{ $t->user->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $t->getStatusBadgeClass() }}">
                                            {{ $t->getStatusLabel() }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('agent.tickets.show', $t->id_tiket) }}"
                                            class="btn-action btn-action-lihat">
                                            <span class="material-icons">visibility</span> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <span class="material-icons" style="font-size: 4rem; color: #ccc;">inbox</span>
                                        <p class="text-muted mt-3 mb-0">Belum ada tiket yang ditugaskan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#tiket-table').DataTable({
                responsive: true,
                order: [[0, 'desc']],
                columnDefs: [{ targets: 0, orderable: false }],
                drawCallback: function() {
                    var api = this.api();
                    var start = api.page.info().start;
                    api.column(0, { page: 'current' }).nodes().each(function(cell, i) {
                        $(cell).html(start + i + 1);
                    });
                },
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                }
            });
        });
    </script>
@endpush
