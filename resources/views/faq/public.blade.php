@extends('component.app')

@push('styles')
    <style>
        .faq-section {
            position: relative;
            z-index: 1;
            min-height: calc(100vh - 130px);
            display: flex;
            align-items: center;
            padding: 80px 0;
        }

        .faq-title {
            text-align: center;
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 32px;
            color: #1e293b;
        }

        .faq-title span {
            color: #1565C0;
        }

        .faq-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, .06);
            padding: 8px 0;
            max-width: 860px;
            margin: 0 auto;
        }

        .faq-item {
            border-bottom: 1px solid #f1f5f9;
            padding: 0 24px;
        }

        .faq-item:last-child {
            border-bottom: none;
        }

        .faq-btn {
            display: flex;
            align-items: center;
            gap: 14px;
            width: 100%;
            background: none;
            border: none;
            padding: 18px;
            cursor: pointer;
            text-align: left;
            font-size: .95rem;
            font-weight: 500;
            color: #1e293b;
        }

        .faq-btn:focus {
            outline: none;
        }

        .faq-number {
            min-width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #1565C0;
            color: #fff;
            font-size: .8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .faq-btn .faq-question {
            flex: 1;
            font-weight: bold;
        }

        .faq-chevron {
            font-size: 20px;
            color: #94a3b8;
            transition: transform .25s ease;
        }

        .faq-btn[aria-expanded="true"] .faq-chevron {
            transform: rotate(180deg);
        }

        .faq-body {
            padding: 16px 0 16px 24px;
            font-size: .9rem;
            color: #475c7a;
            line-height: 1.7;
        }

        .faq-body a {
            color: #1565C0;
            font-size: .85rem;
        }

        .faq-item.is-active .faq-btn {
            background: #dbeafe;
            color: #1565C0;
            border-radius: 12px;
        }
    </style>
@endpush

@section('content')
    <div class="faq-section">
        <div class="container">
            <h2 class="faq-title">
                Pertanyaan Umum yang Sering Ditanyakan <span>Pengguna HelpDesk</span>
            </h2>

            <div class="faq-card" id="faqAccordion">

                @foreach ($faqs as $index => $faq)
                    <div class="faq-item">
                        <button class="faq-btn" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapse{{ $faq->id }}" aria-expanded="false"
                            aria-controls="faqCollapse{{ $faq->id }}">
                            <div class="faq-number">{{ $index + 1 }}</div>
                            <span class="faq-question">{{ $faq->question }}</span>
                            <span class="material-symbols-outlined faq-chevron">expand_more</span>
                        </button>

                        <div id="faqCollapse{{ $faq->id }}" class="collapse" data-bs-parent="#faqAccordion">
                            <div class="faq-body">
                                <div class="border-start border-4 border-warning ms-1 ps-2">
                                    {!! $faq->answer !!}
                                    @if ($faq->file)
                                        <a href="{{ asset('storage/' . $faq->file) }}" target="_blank">
                                            <span class="material-symbols-outlined"
                                                style="font-size:16px; vertical-align:-3px;">attach_file</span>
                                            Lihat Lampiran
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </div>
    @push('scripts')
        <script>
            document.querySelectorAll('.faq-item .collapse').forEach(function(el) {
                el.addEventListener('show.bs.collapse', function() {
                    this.closest('.faq-item').classList.add('is-active');
                });
                el.addEventListener('hide.bs.collapse', function() {
                    this.closest('.faq-item').classList.remove('is-active');
                });
            });
        </script>
    @endpush
@endsection
