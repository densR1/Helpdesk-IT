@extends('component.app')

@section('title', 'HelpDesk IT')

@section('nav-links')
@endsection
@section('content')

    <main>
        <!-- Hero Section -->
        <section class="features-section">
            <div class="tech-pattern"></div>
            <div class="container px-4">
                <div class="row align-items-center g-5">

                    <!-- LEFT -->
                    <div class="col-lg-6 text-start">
                        <div class="trusted-badge">
                            <span class="material-symbols-outlined" style="font-size: 18px;">
                                verified_user
                            </span>
                            500+ Problem Solved
                        </div>

                        <h1 class="display-large">
                            Manage Everything,
                            <span class="text-primary">Effortlessly</span>.
                        </h1>

                        <p class="body-large">
                            Platform helpdesk modern untuk tim Anda. Otomatiskan alur kerja,
                            pantau semua tiket dalam satu dasbor, dan berikan pengalaman pelanggan
                            terbaik setiap saat.
                        </p>

                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <a href="{{ route('login') }}" class="btn btn-primary fw-bold d-flex align-items-center gap-2">
                                Ajukan Tiket
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- RIGHT -->
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="position-relative">
                            <img src="/images/bg-hero.png" alt="System dashboard" class="img-fluid">

                            <div class="stat-card">
                                <div class="stat-icon">
                                    <span class="material-symbols-outlined">bolt</span>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small fw-medium">
                                        Avg. Response Time
                                    </p>
                                    <p class="mb-0 h4 fw-bold text-primary">
                                        12m 45s
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Statistik Section -->
        <section class="cta-section text-white">
            <div class="container px-4">

                <div class="text-center mb-5">
                    <h2 class="fw-bold mb-3">Statistik Pengerjaan</h2>
                    <p class="mx-auto" style="max-width: 600px;">
                        Ringkasan metrik tiket dan layanan tanpa statistik mahasiswa.
                    </p>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-sm-6 col-xl-4">
                        <div class="rounded-4 bg-white shadow p-3 w-100 h-100">
                            <div class="vstack align-items-center">
                                <div class="hstack gap-2 justify-content-center">
                                    <span class="material-symbols-outlined notranslate icon-stat" translate="no">
                                        task_alt
                                    </span>
                                    <span class="text-dark fw-bold text-center fs-2 count-up"
                                        data-target="{{ $problemSolved }}">0</span>
                                </div>
                                <span class="text-muted fst-italic">Problem Solved</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-4">
                        <div class="rounded-4 bg-white shadow p-3 w-100 h-100">
                            <div class="vstack align-items-center">
                                <div class="hstack gap-2 justify-content-center">
                                    <span class="material-symbols-outlined notranslate icon-stat" translate="no">
                                        pending_actions
                                    </span>
                                    <span class="text-dark fw-bold text-center fs-2 count-up"
                                        data-target="{{ $tiketAktif }}">0</span>
                                </div>
                                <span class="text-muted fst-italic">Tiket Aktif</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-4">
                        <div class="rounded-4 bg-white shadow p-3 w-100 h-100">
                            <div class="vstack align-items-center">
                                <div class="hstack gap-2 justify-content-center">
                                    <span class="material-symbols-outlined notranslate icon-stat" translate="no">
                                        category
                                    </span>
                                    <span class="text-dark fw-bold text-center fs-2 count-up"
                                        data-target="{{ $kategoriLayanan }}">0</span>
                                </div>
                                <span class="text-muted fst-italic">Kategori Layanan</span>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-sm-6 col-xl-3">
                        <div class="rounded-4 bg-white shadow p-3 w-100 h-100">
                            <div class="vstack align-items-center">
                                <div class="hstack gap-2 justify-content-center">
                                    <span class="material-symbols-outlined notranslate icon-stat" translate="no">
                                        location_on
                                    </span>
                                    <span class="text-dark fw-bold text-center fs-2 count-up" data-target="100"
                                        data-suffix="+">0</span>
                                </div>
                                <span class="text-muted fst-italic">Lokasi Terlayani</span>
                            </div>
                        </div>
                    </div> --}}
                </div>

            </div>
        </section>
    </main>

    @push('styles')
        <style>
            .feature-card .feature-icon-box {
                min-width: 72px;
                min-height: 72px;
            }

            .icon-stat {
                color: #02C76D;
                font-size: 32px;
            }

            .count-up {
                transition: transform 0.3s ease;
            }

            .count-up.is-animated {
                transform: scale(1.05);
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function animateCountUp(el) {
                const target = parseInt(el.dataset.target, 10) || 0;
                const suffix = el.dataset.suffix || '';
                const duration = 1200;
                const startTime = performance.now();

                function frame(now) {
                    const progress = Math.min((now - startTime) / duration, 1);
                    const value = Math.floor(progress * target);
                    el.textContent = value.toLocaleString('id-ID') + suffix;

                    if (progress < 1) {
                        requestAnimationFrame(frame);
                    }
                }

                el.classList.add('is-animated');
                requestAnimationFrame(frame);
            }

            document.addEventListener('DOMContentLoaded', function() {
                const counters = document.querySelectorAll('.count-up');
                if (!window.IntersectionObserver) {
                    counters.forEach(animateCountUp);
                    return;
                }

                const observer = new IntersectionObserver(function(entries, obs) {
                    entries.forEach(function(entry) {
                        if (!entry.isIntersecting) {
                            return;
                        }
                        animateCountUp(entry.target);
                        obs.unobserve(entry.target);
                    });
                }, {
                    threshold: 0.4
                });

                counters.forEach(function(el) {
                    observer.observe(el);
                });
            });
        </script>
    @endpush

@endsection
