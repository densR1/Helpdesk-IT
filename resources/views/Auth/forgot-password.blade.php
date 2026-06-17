<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Helpdesk</title>

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

        .forgot-wrapper {
            width: 100%;
            max-width: 460px;
            padding: 20px;
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

        .btn-forgot {
            height: 58px;
            border-radius: 16px;
            background: #3766E8;
            color: white;
            font-weight: 600;
            border: none;
            transition: 0.3s;
        }

        .btn-forgot:hover {
            background: #2f59cf;
            color: white;
        }

        .forgot-right {
            min-height: 100vh;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            position: relative;
            overflow: hidden;
            padding: 0;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .forgot-right::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(
                    to top,
                    rgba(0,0,0,0.35),
                    rgba(0,0,0,0.05)
                );

            z-index: 1;
        }

        .forgot-right-content {
            width: 100%;
            height: 100%;
            position: relative;
            z-index: 2;
        }

        .forgot-right-content img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
            display: block;
        }

        .overlay-text {
            position: absolute;
            bottom: 60px;
            left: 60px;
            color: white;
            z-index: 3;
            max-width: 420px;
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

        @media(max-width: 991px) {

            .forgot-wrapper {
                padding: 40px 20px;
            }

            .forgot-right {
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

                <div class="forgot-wrapper">

                    <!-- Logo -->
                    <div class="mb-5 d-flex align-items-center gap-2">
                        <span class="material-icons fs-3 text-primary">headset_mic</span>
                        <h4 class="m-0 fw-bold">Helpdesk System</h4>
                    </div>

                    <!-- Heading -->
                    <div class="mb-4">
                        <h1 class="fw-bold">Lupa Password</h1>

                        <p class="text-muted">
                            Masukkan email akunmu dan kami akan
                            mengirim link reset password.
                        </p>
                    </div>

                    <!-- SESSION STATUS -->
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- FORM -->
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- EMAIL -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control custom-input @error('email') is-invalid @enderror"
                                placeholder="Masukkan emailmu"
                                required>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <!-- BUTTON -->
                        <button type="submit" class="btn btn-forgot w-100">
                            Kirim Link Reset Password
                        </button>

                        <!-- BACK LOGIN -->
                        <p class="text-center mt-4 text-muted">

                            Sudah ingat password?

                            <a href="{{ route('login') }}">
                                Kembali Login
                            </a>

                        </p>

                    </form>

                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="col-lg-6 forgot-right">

                <div class="forgot-right-content">

                    <img src="{{ asset('images/forgot-password.jpg') }}"
                        alt="Forgot Password Illustration">

                    <div class="overlay-text">

                        <h1>Reset Password</h1>

                        <p>
                            Jangan khawatir, kami akan membantu
                            mengamankan akun dan memulihkan aksesmu
                            dengan cepat.
                        </p>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>