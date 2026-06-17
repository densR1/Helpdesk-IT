@extends('layouts.app')

@section('title', 'Kelola FAQ')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0">Manage FAQ</h1>
                <p class="text-muted">Daftar pertanyaan yang sering diajukan</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('faq.create') }}" class="btn btn-primary">
                    <span class="material-icons">add_circle</span> Tambah FAQ
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive p-2 p-md-4">
                    <table id="faqTable" class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:15%">Kategori</th>
                                <th style="width:30%">Pertanyaan</th>
                                <th style="width:15%">Jawaban</th>
                                <th style="width:10%">Status</th>
                                <th style="width:15%">Dibuat</th>
                                <th style="width:10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faqs as $faq)
                                <tr>
                                    <td></td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $faq->kategori->nama_kategori ?? '-' }}</span>
                                    </td>
                                    <td>{{ $faq->question }}</td>
                                    <td>
                                        @if ($faq->answer || $faq->file)
                                            <button type="button" class="btn-action btn-action-lihat faq-answer-btn"
                                                data-bs-toggle="modal" data-bs-target="#answerModal"
                                                data-question="{{ $faq->question }}"
                                                @if ($faq->file) data-file="{{ asset('storage/' . $faq->file) }}" @endif>
                                                <span class="material-icons">visibility</span> Lihat
                                            </button>
                                            @if ($faq->answer)
                                                <div class="d-none faq-answer-content">{!! $faq->answer !!}</div>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($faq->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>{{ $faq->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('faq.edit', $faq->id) }}" class="btn-action btn-action-edit">
                                                <span class="material-icons">edit</span> Edit
                                            </a>
                                            <form action="{{ route('faq.destroy', $faq->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus FAQ ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-action-hapus">
                                                    <span class="material-icons">delete</span> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <span class="material-icons" style="font-size: 4rem; color: #ccc;">inbox</span>
                                        <p class="text-muted mt-3 mb-0">Belum ada FAQ</p>
                                        <a href="{{ route('faq.create') }}" class="btn btn-primary mt-3">
                                            <span class="material-icons">add_circle</span> Tambah FAQ Pertama
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="answerModal" tabindex="-1" aria-labelledby="answerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="answerModalLabel">Jawaban</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="answerModalBody"></div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {
                $('#faqTable').DataTable({
                    responsive: true,
                    order: [
                        [5, 'desc']
                    ],
                    columnDefs: [{
                        targets: 0,
                        orderable: false
                    }],
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
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                    }
                });

                $('#faqTable').on('click', '.faq-answer-btn', function() {
                    var question = $(this).data('question') || 'Jawaban';
                    var file = $(this).data('file');
                    var content = $(this).siblings('.faq-answer-content').html() || '';
                    $('#answerModalLabel').text(question);

                    var html = content ?
                        content :
                        '<p class="text-muted mb-0">Tidak ada jawaban teks.</p>';

                    if (file) {
                        html += '<div class="mt-3 pt-3 border-top">' +
                            '<a href="' + file + '" target="_blank" rel="noopener" ' +
                            'class="btn btn-success d-inline-flex align-items-center gap-1">' +
                            '<span class="material-icons">attach_file</span> Lihat Attachment</a></div>';
                    }

                    $('#answerModalBody').html(html);
                });
            });
        </script>
    @endpush

@endsection
