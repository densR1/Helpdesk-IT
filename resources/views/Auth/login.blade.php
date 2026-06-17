<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Helpdesk</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
        }

        .login-wrapper {
            width: 100%;
            max-width: 460px;
            padding: 20px;
        }

        .login-logo {
            width: 72px;
            height: auto;
        }

        .custom-input {
            height: 58px;
            border-radius: 16px;
            border: 1px solid #ddd;
            padding-left: 18px;
            font-size: 15px;
        }

        .custom-input:focus {
            box-shadow: none;
            border-color: #3766E8;
        }

        /* Hilangkan ikon validasi bawaan Bootstrap supaya tidak menumpuk dengan tombol mata */
        .custom-input.is-invalid {
            background-image: none;
            padding-right: 18px;
        }

        .btn-login {
            height: 58px;
            border-radius: 16px;
            background: linear-gradient(135deg, #1565C0, #1A2980);
            color: white;
            font-weight: 600;
            border: none;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #1565C0, #5866b8);
            color: white;
        }

        .login-right {
            background-image: url('{{ asset('images/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
            padding: 0;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-right-content {
            width: 100%;
            height: 100vh;

            position: relative;

            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .login-right-content img {
            display: none;
        }


        .illustration {
            max-width: 500px;
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 18px;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #777;
        }

        @media(max-width: 991px) {

            .login-wrapper {
                padding: 40px 20px;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row min-vh-100">

            <!-- LEFT SIDE -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center bg-white">

                <div class="login-wrapper">

                    <!-- Logo -->
                    <div
                        class="mb-5 d-flex flex-column flex-sm-row align-items-center justify-content-center gap-3 text-center">
                        <img src="{{ asset('images/logo-helpdesk.png') }}" alt="Helpdesk IT" class="login-logo">
                        <h1 class="fs-2 m-0 fw-bold">Helpdesk IT</h1>
                    </div>

                    <!-- Heading -->
                    <div class="mb-4">
                        <h4 class="fw-bold">Login</h4>
                        <p class="text-muted">
                            Selamat datang di Helpdesk System
                        </p>
                    </div>

                    <!-- Form -->
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-4 d-flex align-items-center gap-2" role="alert">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Email</label>

                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control custom-input @error('email') is-invalid @enderror"
                                placeholder="Masukkan emailmu">
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>

                            <div class="password-wrapper">
                                <input id="password-field" type="password" name="password"
                                    class="form-control custom-input @error('password') is-invalid @enderror"
                                    placeholder="Passwordmu">

                                <button type="button" class="toggle-password" id="togglePassword">

                                    <i class="fa-solid fa-eye-slash"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember -->
                        <div class="d-flex justify-content-between mb-4">

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">
                                    Ingat saya
                                </label>
                            </div>

                            <a href="#" class="text-decoration-none">
                                Lupa password?
                            </a>
                        </div>

                        <!-- Button -->
                        <button class="btn btn-login w-100">
                            Login
                        </button>

                        {{-- <p class="text-center mt-4 text-muted">
                            Belum punya akun?
                            <a href="{{ route('register') }}">
                                Daftar
                            </a>
                        </p> --}}
                        <div class="text-center mt-4">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalDaftarAdmin"
                                class="text-decoration-none fw-semibold">
                                Belum Punya Akun?
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="col-lg-6 login-right">

                <div class="login-right-content">

                    <img src="{{ asset('images/background.jpg') }}" alt="Illustration">

                </div>

            </div>
        </div>

    </div>
    </div>
    </div>

    {{-- ini modal --}}
    <div class="modal fade" id="modalDaftarAdmin" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-body text-center p-4">
                    <i class="fa-solid fa-user-shield text-primary" style="font-size: 48px;"></i>
                    <h5 class="fw-bold mt-3 mb-2">Belum Punya Akun?</h5>
                    <p class="text-muted" style="font-size: .9rem;">
                        Akun HelpDesk IT hanya dapat dibuat oleh <strong>Admin</strong>.
                        Silakan hubungi admin IT untuk mendaftarkan akunmu.
                    </p>
                    <hr>
                    <p class="text-muted mb-1" style="font-size: .85rem;">Kontak Admin IT</p>
                    <p class="fw-semibold mb-0">
                        <i class="fa-solid fa-envelope me-1"></i>
                        admin@helpdeskit.com
                    </p>
                    <button class="btn btn-login w-100 mt-4" data-bs-dismiss="modal">Oke, Mengerti</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<script>
    const toggle = document.getElementById('togglePassword');
    const input = document.getElementById('password-field');
    const icon = toggle.querySelector('i');

    toggle.addEventListener('click', () => {
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        icon.classList.toggle('fa-eye', isHidden);
        icon.classList.toggle('fa-eye-slash', !isHidden);
    });
</script>
