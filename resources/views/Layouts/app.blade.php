<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Helpdesk System')</title>
    @stack('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon.png') }}">
    <!-- Custom CSS -->
    <style>
        :root {
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: #22328d;
            padding-top: 20px;
            z-index: 1000;
        }

        .sidebar .brand {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            padding: 0 20px 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-left: 3px solid #fff;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: #f8f9fa;
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
        }

        .content-wrapper {
            padding: 2rem;
        }

        .card {
            border: none;
            margin-bottom: 1.5rem;
            border-radius: 24px;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
            padding: 16px;
        }

        .badge-role {
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1565C0, #1A2980);
            color: #fff;
            padding: 12px 24px;
            border-radius: 10px;
            border: none;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(21, 101, 192, 0.35);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: linear-gradient(135deg, #1976D2, #1565C0);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(21, 101, 192, 0.45);
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(21, 101, 192, 0.35);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #546e7a, #37474f);
            color: #fff;
            padding: 12px 24px;
            border-radius: 10px;
            border: none;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(55, 71, 79, 0.3);
        }

        .btn-secondary:hover,
        .btn-secondary:focus {
            background: linear-gradient(135deg, #607d8b, #546e7a);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(55, 71, 79, 0.4);
        }

        .btn-secondary:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(55, 71, 79, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #388E3C, #2E7D32);
            color: #fff;
            padding: 12px 24px;
            border-radius: 10px;
            border: none;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(46, 125, 50, 0.35);
        }

        .btn-success:hover,
        .btn-success:focus {
            background: linear-gradient(135deg, #43A047, #388E3C);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(46, 125, 50, 0.45);
        }

        .btn-success:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(46, 125, 50, 0.35);
        }

        .btn-primary-1 {
            background-color: #22328d;
            color: white;
            border: none;
            border-radius: 8px;
        }

        .btn-primary-1:hover,
        .btn-primary-1:focus {
            background-color: #16236a;
            color: white;
        }

        .navbar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1565C0, #1A2980);
            color: #fff;
            font-size: 0.85rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-username {
            font-size: 0.85rem;
            color: #1a1a2e;
            font-weight: 600;
        }

        .navbar-role {
            font-size: 0.72rem;
            color: #94a3b8;
        }

        .navbar-logout-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: #fff0f0;
            color: #e53935;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .navbar-logout-btn:hover {
            background: #e53935;
            color: #fff;
            transform: rotate(-10deg);
        }

        .navbar-logout-btn .material-icons {
            font-size: 20px;
        }

        .material-icons {
            font-size: 24px;
            vertical-align: middle;
            line-height: 1;
        }

        .material-icons.md-lg {
            font-size: 3rem;
        }

        /* Action buttons */
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            font-size: 0.8rem;
            font-weight: 500;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
        }

        .btn-action:active {
            transform: translateY(0);
        }

        .btn-action-edit {
            background: linear-gradient(135deg, #1976D2, #1565C0);
            color: #fff;
        }

        .btn-action-edit:hover {
            color: #fff;
        }

        .btn-action-hapus {
            background: linear-gradient(135deg, #E53935, #C62828);
            color: #fff;
        }

        .btn-action-hapus:hover {
            color: #fff;
        }

        .btn-action-lihat {
            background: linear-gradient(135deg, #388E3C, #2E7D32);
            color: #fff;
        }

        .btn-action-lihat:hover {
            color: #fff;
        }

    </style>
    @stack('styles')
</head>

<body>

    <!-- Sidebarx -->
    <div class="sidebar">
        <div class="brand d-flex align-items-center">
            <img src="{{ asset('images/logo-helpdesk.png') }}" alt="Logo" width="48" height="48"
                class="me-2 rounded"> Helpdesk IT
        </div>

        <nav class="nav flex-column">
            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <span class="material-icons">dashboard</span> Dashboard
            </a>
            @if (auth()->user()->isUser() || auth()->user()->isAdmin())
                <a class="nav-link {{ request()->is('tickets') && !request()->is('tickets/create') ? 'active' : '' }}"
                    href="{{ route('tickets.index') }}">
                    <span class="material-icons">confirmation_number</span>
                    @if (auth()->user()->isAdmin())
                        Semua Tiket
                    @else
                        Tiket Saya
                    @endif
                </a>
            @endif
            {{-- @if (auth()->user()->isUser() || auth()->user()->isAdmin())
                <a class="nav-link {{ request()->is('tickets/create') ? 'active' : '' }}"
                    href="{{ route('tickets.create') }}">
                    <span class="material-icons">add_circle</span> Buat Tiket
                </a>
            @endif --}}

            {{-- @if (auth()->check() && auth()->user()->isUser())
            <a class="nav-link {{ request()->is('tickets*') ? 'active' : '' }}" href="#">
                <span class="material-icons">confirmation_number</span> My Tickets
            </a>
            <a class="nav-link" href="#">
                <span class="material-icons">add_circle</span> Create Ticket
            </a>
            @endif --}}

            @if (auth()->check() && auth()->user()->isAgent())
                <a class="nav-link {{ request()->is('agent/tickets*') ? 'active' : '' }}"
                    href="{{ route('agent.tickets') }}">
                    <span class="material-icons">assignment_ind</span> Ditugaskan Kepada Saya
                </a>
            @endif
            @if (auth()->user()->isAdmin())
                <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <span class="material-icons">group</span> Users
                </a>
            @endif

            @if (auth()->check() && auth()->user()->isAdmin())
                <a class="nav-link {{ request()->is('categories*') ? 'active' : '' }}"
                    href="{{ route('categories.index') }}">
                    <span class="material-icons">label</span> Kategori
                </a>
            @endif

            @if (auth()->check())

                {{-- ADMIN --}}
                @if (auth()->user()->isAdmin())
                    <a class="nav-link {{ request()->is('faq*') ? 'active' : '' }}" href="{{ route('faq.index') }}">
                        <span class="material-icons">settings</span> Kelola FAQ
                    </a>
                @endif

                {{-- USER --}}
                @if (auth()->user()->isUser())
                    <a class="nav-link {{ request()->is('faq-user') ? 'active' : '' }}"
                        href="{{ route('faq.user') }}">
                        <span class="material-icons">help</span> FAQ
                    </a>
                @endif

            @endif
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <div class="ms-auto d-flex align-items-center">
                    @auth
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="navbar-avatar">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="lh-sm">
                                    <div class="fw-600 navbar-username">{{ auth()->user()->name }}</div>
                                    <div class="navbar-role">{{ auth()->user()->role->display_name ?? '' }}</div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="navbar-logout-btn">
                                    <span class="material-icons">logout</span>
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="content-wrapper">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="material-icons">check_circle</span> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="material-icons">warning</span> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (optional, kalo butuh) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


    @stack('scripts')
</body>

</html>
