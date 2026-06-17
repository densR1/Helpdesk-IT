@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0">Manage Users</h1>
                <p class="text-muted">Kelola semua user dalam sistem</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <span class="material-icons">add_circle</span> Tambah User Baru
                </a>
            </div>
        </div>

        <div class="card rounded-4 shadow">
            <div class="card-body">
                <div class="table-responsive p-2 p-md-4">
                    <table id="usersTable" class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:20%">Nama</th>
                                <th style="width:25%">Email</th>
                                <th style="width:15%">Role</th>
                                <th style="width:15%">Dibuat</th>
                                <th style="width:20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td></td>
                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                        @if ($user->id === auth()->id())
                                            <span class="badge bg-info">You</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->role->name === 'admin')
                                            <span class="badge bg-danger">{{ $user->role->display_name }}</span>
                                        @elseif($user->role->name === 'agent')
                                            <span class="badge bg-warning">{{ $user->role->display_name }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $user->role->display_name }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('users.edit', $user) }}"
                                                class="btn-action btn-action-edit">
                                                <span class="material-icons">edit</span> Edit
                                            </a>
                                            @if ($user->id !== auth()->id())
                                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-action btn-action-hapus">
                                                        <span class="material-icons">delete</span> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <span class="material-icons" style="font-size: 3rem; color: #ccc;">inbox</span>
                                        <p class="text-muted mt-2">Belum ada user</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(function() {
                $('#usersTable').DataTable({
                    responsive: true,
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
            });
        </script>
    @endpush

@endsection
