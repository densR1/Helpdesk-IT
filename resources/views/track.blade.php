@extends('component.app')

@section('title', 'Lacak Tiket — HelpDesk IT')

@section('nav-links')

@endsection
@push('styles')
    <style>
        .page-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .page-header h1 {
            font-weight: 800;
        }

        .page-header p {
            color: rgba(255, 255, 255, .5);
        }

        .search-box {
            max-width: 600px;
            margin: 0 auto 40px;
        }

        .search-inner {
            display: flex;
            gap: 10px;
        }

        /* SUMMARY */
        .ticket-summary {
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-direction: column;
        }

        /* STATUS */
        .status-badge {
            padding: 6px 14px;
            border-radius: 50px;
            font-size: .75rem;
        }

        .s-pending {
            background: rgba(148, 163, 184, .2);
            color: #64748b;
        }

        .s-assigned {
            background: rgba(21, 101, 192, .15);
            color: #1565C0;
        }

        .s-progress {
            background: rgba(234, 179, 8, .2);
            color: #b45309;
        }

        .s-done {
            /* selesai - ijo */
            background: rgba(34, 197, 94, .2);
            color: #16a34a;
        }

        .meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            margin-top: 10px;
        }

        .meta-item {
            padding: 0;
            background: transparent;
            min-width: max-content;
            font-size: 0.85rem;
            color: #64748b;
        }

        .meta-item b {
            display: block;
            font-size: 1rem;
            color: #000;
        }

        .progress-card {
            padding: 24px;
        }

        .progress-track {
            position: relative;
        }

        .progress-line {
            display: none;
        }

        .progress-steps {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
        }

        .progress-steps::before {
            display: none;
            /* hapus ini */
        }





        .p-step {
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .p-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 17px;
            left: 50%;
            right: -50%;
            height: 6px;
            background: #e2e8f0;
            z-index: -1;
        }

        .p-step.line-done:not(:last-child)::after {
            background: linear-gradient(90deg, var(--teal), #1565C0);
        }

        .circle {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e2e8f0;
            font-size: 14px;
            color: #94a3b8;
            position: relative;
            z-index: 2;
        }

        .done .circle {
            background: linear-gradient(135deg, var(--teal), #1565C0);
            color: #fff;
        }

        .active .circle {
            background: #1565C0;
            color: #fff;
        }

        .p-step span {
            font-size: .7rem;
            color: #94a3b8;
        }

        .done span,
        .active span {
            color: #1565C0;
            font-weight: 600;
        }

        /* AGENT */
        .agent-card {
            padding: 20px;
        }

        .agent-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .agent-ava {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #1565C0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .online {
            color: #4ade80;
            font-size: .75rem;
        }

        .circle .material-symbols-outlined {
            font-size: 18px;
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <div class="page-wrap">
        <div class="container">
            {{-- HEADER --}}
            <div class="page-header pt-3">
                <h1>Lacak Tiket</h1>
                <p class="text-dark">Cek status tiket kamu di sini</p>
            </div>

            {{-- SEARCH --}}
            <div class="search-box">
                <form method="GET">
                    <div class="search-inner">
                        <input type="text" name="kode_tiket" class="form-control" placeholder="Masukkan Kode Tiket Kamu"
                            value="{{ request('kode_tiket') ?? request('ticket_id') }}">
                        <button class="btn-primary">Lacak</button>
                    </div>
                </form>
            </div>

            {{-- RESULT --}}
            @if (isset($ticket) && $ticket)
                <div class="glass-card ticket-summary flex-column mb-3 shadow">
                    <div class="d-flex justify-content-between align-items-start w-100 mb-3">
                        <div>
                            <strong>ID Tiket</strong><br>
                            <small>{{ $ticket->kode_tiket ?? '#' . $ticket->id_tiket }} - {{ $ticket->judul }}</small>
                        </div>
                        @php
                            $badgeClass = match ($ticket->status) {
                                \App\Models\Tiket::STATUS_PENDING => 's-pending',
                                \App\Models\Tiket::STATUS_APPROVED => 's-assigned',
                                \App\Models\Tiket::STATUS_IN_PROGRESS => 's-progress',
                                \App\Models\Tiket::STATUS_CONFIRM => 's-progress',
                                \App\Models\Tiket::STATUS_COMPLETED => 's-done',
                                default => 's-pending',
                            };
                        @endphp
                        <div class="status-badge {{ $badgeClass }}">{{ $ticket->getStatusLabel() }}</div>
                    </div>

                    <div class="meta-row w-100">
                        <div class="meta-item">Kategori<br><b>{{ $ticket->category->nama_kategori ?? '-' }}</b></div>
                        <div class="meta-item">Pembuat<br><b>{{ $ticket->user->name ?? '-' }}</b></div>
                        <div class="meta-item">Dibuat<br><b>{{ $ticket->created_at->format('d M Y') }}</b></div>
                        <div class="meta-item">Update<br><b>{{ $ticket->updated_at->format('d M Y') }}</b></div>
                    </div>
                </div>

                {{-- PROGRESS — hanya tampil kalau tiket ditemukan --}}
                @php
                    $st = $ticket->status;
                    $T = \App\Models\Tiket::class;

                    // done = milestone benar-benar tercapai (tampil centang hijau)
                    $done = [
                        'created' => true,
                        'approved' => $st >= $T::STATUS_APPROVED,
                        'assigned' => $st >= $T::STATUS_APPROVED, // approve & assign terjadi bersamaan
                        'inprogress' => $st >= $T::STATUS_COMPLETED, // Confirm dianggap masih proses
                        'completed' => $st >= $T::STATUS_COMPLETED,
                    ];

                    // active (biru) hanya saat tiket sedang dikerjakan / menunggu konfirmasi user
                    $activeKey = in_array($st, [$T::STATUS_IN_PROGRESS, $T::STATUS_CONFIRM]) ? 'inprogress' : null;

                    $stepDefs = [
                        ['key' => 'created', 'label' => 'Dibuat', 'icon' => 'edit_note'],
                        ['key' => 'approved', 'label' => 'Approve', 'icon' => 'thumb_up'],
                        ['key' => 'assigned', 'label' => 'Assign', 'icon' => 'person_add'],
                        ['key' => 'inprogress', 'label' => 'Proses', 'icon' => 'hourglass_top'],
                        ['key' => 'completed', 'label' => 'Selesai', 'icon' => 'task_alt'],
                    ];
                @endphp

                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="glass-card progress-card shadow">
                            <h6 class="fw-bold mb-3">Progress</h6>

                            <div class="progress-track">
                                <div class="progress-steps">
                                    @foreach ($stepDefs as $i => $step)
                                        @php
                                            $isDone = $done[$step['key']];
                                            $isActive = $activeKey === $step['key'];
                                            // garis penghubung berwarna hanya jika step berikutnya sudah done / active
                                            $next = $stepDefs[$i + 1]['key'] ?? null;
                                            $lineDone = $next && ($done[$next] || $activeKey === $next);
                                        @endphp
                                        <div
                                            class="p-step {{ $isDone ? 'done' : ($isActive ? 'active' : '') }} {{ $lineDone ? 'line-done' : '' }}">
                                            <div class="circle">
                                                <span
                                                    class="material-symbols-outlined">{{ $isDone ? 'check' : $step['icon'] }}</span>
                                            </div>
                                            <span>{{ $step['label'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @elseif(request()->has('kode_tiket') || request()->has('ticket_id'))
                <div class="alert alert-warning">Tiket tidak ditemukan untuk kode tersebut.</div>
            @else
                <div class="text-center text-muted mb-4">Masukkan kode tiket di atas untuk melacak.</div>
            @endif

        </div>
    </div>
    @push('scripts')
        <script>
            const [entry] = performance.getEntriesByType('navigation');
            if (entry.type === 'reload' && window.location.search) {
                window.location.replace(window.location.pathname);
            }
        </script>
    @endpush
@endsection
