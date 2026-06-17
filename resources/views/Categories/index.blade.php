@extends('layouts.app')

@section('title', 'Manage Categories')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0">Manage Categories</h1>
                <p class="text-muted">Kelola kategori ticket</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <span class="material-icons">add_circle</span> Tambah Kategori
                </a>
            </div>
        </div>

        <div class="card rounded-4 shadow">
            <div class="card-body">
                <div class="table-responsive p-2 p-md-4">
                    <table id="categoriesTable" class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Kategori</th>
                                <th width="180">Dibuat</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td></td>
                                    <td><strong>{{ $category->nama_kategori }}</strong></td>
                                    <td>{{ $category->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('categories.edit', $category) }}"
                                                class="btn-action btn-action-edit">
                                                <span class="material-icons">edit</span> Edit
                                            </a>
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                                    <td colspan="4" class="text-center py-4">
                                        <span class="material-icons" style="font-size: 3rem; color: #ccc;">inbox</span>
                                        <p class="text-muted mt-2">Belum ada kategori</p>
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
                $('#categoriesTable').DataTable({
                    responsive: true,
                    order: [[2, 'desc']],
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

@endsection
