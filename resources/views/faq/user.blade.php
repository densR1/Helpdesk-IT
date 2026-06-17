@extends('Layouts.app')

@section('title', 'FAQ')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0">Pertanyaan yang Sering Diajukan</h1>
                <p class="text-muted">Temukan jawaban atas pertanyaan umum di sini</p>
            </div>
        </div>

        <div class="row">
            {{-- FAQ Accordion --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-4">

                        @forelse($faqs as $faq)
                            <div class="faq-item mb-2">
                                <button class="faq-question w-100 d-flex align-items-center justify-content-between"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faq{{ $faq->id }}"
                                    aria-expanded="false">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="faq-number">{{ $loop->iteration + ($faqs->currentPage() - 1) * $faqs->perPage() }}</span>
                                        <span class="faq-question-text">{{ $faq->question }}</span>
                                    </div>
                                    <span class="material-icons faq-chevron">expand_more</span>
                                </button>

                                <div id="faq{{ $faq->id }}" class="collapse">
                                    <div class="faq-answer">
                                        <div class="border-start border-4 border-warning ms-1 ps-3">
                                            @if($faq->answer)
                                                <div class="faq-answer-content">{!! $faq->answer !!}</div>
                                            @endif

                                            @if($faq->file)
                                                <a href="{{ asset('storage/' . $faq->file) }}" target="_blank"
                                                    class="btn-action btn-action-lihat mt-3 d-inline-flex">
                                                    <span class="material-icons">attach_file</span> Lihat Lampiran
                                                </a>
                                            @endif

                                            @if(!$faq->answer && !$faq->file)
                                                <p class="text-muted mb-0">Jawaban belum tersedia.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <span class="material-icons" style="font-size: 4rem; color: #ccc;">inbox</span>
                                <p class="text-muted mt-3">Tidak ada FAQ ditemukan.</p>
                            </div>
                        @endforelse

                        @if($faqs->hasPages())
                            <div class="mt-4">
                                {{ $faqs->appends(request()->query())->links() }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            {{-- Filter --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #1565C0, #1A2980); border-radius: 16px 16px 0 0;">
                        <h6 class="mb-0"><span class="material-icons">filter_list</span> Filter FAQ</h6>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('faq.user') }}">
                            <div class="mb-3">
                                <label class="form-label">Cari Pertanyaan</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control" placeholder="Ketik kata kunci...">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="category" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ request('category') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <span class="material-icons">search</span> Cari
                            </button>

                            @if(request('search') || request('category'))
                                <a href="{{ route('faq.user') }}" class="btn btn-secondary w-100 mt-2">
                                    Reset Filter
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .faq-item {
                border: 1px solid #e9ecef;
                border-radius: 12px;
                overflow: hidden;
                transition: box-shadow 0.2s ease;
            }
            .faq-item:has(.collapse.show) {
                box-shadow: 0 4px 16px rgba(21, 101, 192, 0.12);
                border-color: #bbdefb;
            }
            .faq-question {
                background: #fff;
                border: none;
                padding: 16px 20px;
                cursor: pointer;
                text-align: left;
                transition: background 0.2s ease;
            }
            .faq-question:hover {
                background: #f5f9ff;
            }
            .faq-question[aria-expanded="true"] {
                background: #e8f0fe;
            }
            .faq-number {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 30px;
                height: 30px;
                min-width: 30px;
                background: #1565C0;
                color: #fff;
                border-radius: 50%;
                font-size: 0.8rem;
                font-weight: 600;
            }
            .faq-question-text {
                font-weight: 500;
                font-size: 0.95rem;
                color: #1a1a2e;
            }
            .faq-chevron {
                color: #1565C0;
                transition: transform 0.3s ease;
                flex-shrink: 0;
            }
            .faq-question[aria-expanded="true"] .faq-chevron {
                transform: rotate(180deg);
            }
            .faq-answer {
                padding: 16px 20px 20px;
                border-top: 1px solid #e9ecef;
                background: #fafafa;
                color: #475c7a;
                font-size: 0.92rem;
                line-height: 1.7;
            }
            .faq-attachment-link {
                color: #1565C0;
                font-size: 0.85rem;
                text-decoration: none;
            }
            .faq-attachment-link:hover {
                text-decoration: underline;
            }
        </style>
    @endpush
@endsection
