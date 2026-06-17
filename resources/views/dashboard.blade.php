@extends('layouts.app')

@section('title', 'Dashboard - Helpdesk')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0">Dashboard</h1>
                <p class="text-muted">Selamat datang, {{ auth()->user()->name }}!</p>
            </div>
        </div>

        <div class="row">
            <!-- Stats Cards -->
            <div class="col-md-3">
                <div class="card border-start border-primary border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Tickets</h6>
                                <h2 class="mb-0">{{ $total }}</h2>
                            </div>
                            <div class="text-primary" style="font-size: 2.5rem;">
                                <span class="material-icons">confirmation_number</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-start border-warning border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Waiting List</h6>
                                <h2 class="mb-0">{{ $pending }}</h2>
                            </div>
                            <div class="text-warning" style="font-size: 2.5rem;">
                                <span class="material-icons">error</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-start border-info border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">In Progress</h6>
                                <h2 class="mb-0">{{ $inProgress }}</h2>
                            </div>
                            <div class="text-info" style="font-size: 2.5rem;">
                                <span class="material-icons">hourglass_empty</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-start border-success border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Resolved</h6>
                                <h2 class="mb-0">{{ $completed }}</h2>
                            </div>
                            <div class="text-success" style="font-size: 2.5rem;">
                                <span class="material-icons">check_circle</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($completedTickets->count() > 0)
            <div class="card rounded-4 shadow">
                <div class="card-body">

                    {{-- <div class="text-center py-5">
                @if (auth()->user()->isUser() || auth()->user()->isAdmin())
                    <span class="material-icons" style="font-size: 4rem; color: #ccc;">inbox</span>
                    <p class="text-muted mt-3">Belum ada ticket. Mulai buat ticket pertama!</p>

                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateTicket">
                        <span class="material-icons">add_circle</span> Create New Ticket
                    </button>
                @endif
            </div> --}}

                    <h6 class="mb-3 fw-bold">Recent Tickets Completed</h6>

                    <div class="table-responsive p-2 p-md-4">
                        <table class="table table-striped table-bordered table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Selesai Pada</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($completedTickets as $ticket)
                                    <tr>
                                        <td>{{ $ticket->judul }}</td>
                                        <td>{{ $ticket->user->name ?? '-' }}</td>
                                        <td><span class="badge bg-success">{{ $ticket->getStatusLabel() }}</span></td>
                                        <td>{{ $ticket->updated_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('agent.tickets.show', $ticket->id_tiket) }}"
                                                class="btn btn-sm btn-primary">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>


                </div>

            </div>
        @endif
    @endsection
