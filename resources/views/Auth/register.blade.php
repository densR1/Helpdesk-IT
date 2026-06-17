<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Helpdesk</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            overflow-x: hidden;
        }

        .register-wrapper {
            width: 100%;
            max-width: 460px;
            padding: 20px;
        }

        .custom-input {
            height: 58px;
            border-radius: 16px;
            border: 1px solid #ddd;
            background-color: #3766e812;
            padding-left: 18px;
            font-size: 15px;
        }

        .custom-input:focus {
            box-shadow: none;
            border-color: #3766E8;
        }

        .btn-register {
            height: 58px;
            border-radius: 16px;
            background: #3766E8;
            color: white;
            font-weight: 600;
            border: none;
            transition: 0.3s;
        }

        .btn-register:hover {
            background: #2f59cf;
            color: white;
        }

        .register-right {
                background: linear-gradient(135deg, #2563eb, #3b82f6);
    position: relative;
    overflow: hidden;
    padding: 0;

    display: flex;
    align-items: center;
    justify-content: center;
        }


        .register-right-content {
            width: 100%;
            height: 100%;
            overflow: hidden;
            padding:
        }

        .register-right-content img {
            width: 100%;
            height: 107vh;
            object-fit: cover;
            display: block;
        }

        .overlay-text {
            position: absolute;
            bottom: 60px;
            left: 60px;
            color: white;
            z-index: 3;
            max-width: 400px;
        }

        .overlay-text h1 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .overlay-text p {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.7;
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

            .register-wrapper {
                padding: 40px 20px;
            }

            .register-right {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row min-vh-100">

            <!-- LEFT SIDE -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center bg-white">

                <div class="register-wrapper">

                    <!-- Logo -->
                    <div class="mb-5 d-flex align-items-center gap-2">
                        <span class="material-icons fs-3 text-primary">headset_mic</span>
                        <h4 class="m-0 fw-bold">Helpdesk System</h4>
                    </div>

                    <!-- Heading -->
                    <div class="mb-4">
                        <h1 class="fw-bold">Daftar</h1>
                        <p class="text-muted">
                            Buat akun untuk mengajukan tiket bantuan
                        </p>
                    </div>

                    <!-- FORM -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- NAME -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nama
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control custom-input"
                                placeholder="Masukkan namamu"
                                required>
                        </div>

                        <!-- EMAIL -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control custom-input"
                                placeholder="Masukkan emailmu"
                                required>
                        </div>

                        <!-- PASSWORD -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Password
                            </label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    name="password"
                                    id="password-field"
                                    class="form-control custom-input"
                                    placeholder="Masukkan password"
                                    required>

                                <button
                                    type="button"
                                    class="toggle-password"
                                    id="togglePassword">

                                    <i class="fa-solid fa-eye-slash"></i>

                                </button>
                            </div>
                        </div>

                        <!-- CONFIRM PASSWORD -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Konfirmasi Password
                            </label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="confirm-password-field"
                                    class="form-control custom-input"
                                    placeholder="Konfirmasi password"
                                    required>

                                <button
                                    type="button"
                                    class="toggle-password"
                                    id="toggleConfirmPassword">

                                    <i class="fa-solid fa-eye-slash"></i>

                                </button>
                            </div>
                        </div>

                        <!-- BUTTON -->
                        <button type="submit" class="btn btn-register w-100">
                            Daftar
                        </button>

                        <!-- LOGIN -->
                        <p class="text-center mt-4 text-muted">
                            Sudah punya akun?
                            <a href="{{ route('login') }}">
                                Masuk
                            </a>
                        </p>

                    </form>

                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="col-lg-6 register-right">

                <div class="register-right-content">

                    <img src="{{ asset('images/register.jpg') }}"
                        alt="Register Illustration">

                </div>

            </div>

        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        // PASSWORD
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password-field');
        const passwordIcon = togglePassword.querySelector('i');

        togglePassword.addEventListener('click', () => {

            const isHidden = passwordField.type === 'password';

            passwordField.type = isHidden ? 'text' : 'password';

            passwordIcon.classList.toggle('fa-eye');
            passwordIcon.classList.toggle('fa-eye-slash');

        });

        // CONFIRM PASSWORD
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordField = document.getElementById('confirm-password-field');
        const confirmPasswordIcon = toggleConfirmPassword.querySelector('i');

        toggleConfirmPassword.addEventListener('click', () => {

            const isHidden = confirmPasswordField.type === 'password';

            confirmPasswordField.type = isHidden ? 'text' : 'password';

            confirmPasswordIcon.classList.toggle('fa-eye');
            confirmPasswordIcon.classList.toggle('fa-eye-slash');

        });
    </script>

</body>

</html>