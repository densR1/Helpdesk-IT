<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IT Helpdesk')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0"
        rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon.png') }}">

    <style>
        :root {
            --bs-primary: #1565C0;
            --bs-primary-rgb: 21, 101, 192;
            --surface-background: #f4faff;
            --text-on-surface-variant: #424752;
            --teal: #26D0CE;
        }

        body {
            rgba(13, 27, 75, .75) font-family: 'Poppins', sans-serif;
            background-color: var(--surface-background);
            color: #111d23;
            -webkit-font-smoothing: antialiased;
        }

        .navbar {
            background-color: rgb(255, 255, 255);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #dee2e6;
            height: 80px;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: -1px;
            color: var(--surface-background) !from-important;
            font-size: 1.5rem;
        }

        .nav-link {
            font-weight: 500;
            color: #4b5563;
            margin: 0 10px;
            transition: color 0.2s;
        }

        .nav-link:hover {
            color: var(--bs-primary);
        }

        .nav-link.active {
            color: var(--bs-primary);
            border-bottom: 2px solid var(--bs-primary);
        }

        .btn-primary {
            background: linear-gradient(135deg, #1565C0, #1A2980);
            color: #fff;
            padding: 12px 24px;
            border-radius: 10px;
            border: none;
        }


        .btn-outline-secondary {
            border-color: #727783;
            color: #111d23;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 0.5rem;
        }

        .tech-pattern {
            background-color: #f4faff;
            background-image: radial-gradient(#004d99 0.5px, transparent 0.5px), radial-gradient(#004d99 0.5px, #f4faff 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            opacity: 0.05;
            position: absolute;
            inset: 0;
            z-index: -1;
        }

        .hero-section {
            padding-top: 120px;
            padding-bottom: 80px;
            position: relative;
            min-height: 800px;
            display: flex;
            align-items: center;
        }

        .trusted-badge {
            background-color: #cfe6f2;
            color: #071e27;
            padding: 0.25rem 1rem;
            border-radius: 50rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .display-large {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin-bottom: 1.5rem;
        }

        .text-primary {
            color: var(--bs-primary);
        }

        .body-large {
            font-size: 1.125rem;
            line-height: 1.6;
            color: var(--text-on-surface-variant);
            margin-bottom: 2rem;
            max-width: 550px;
        }

        .dashboard-container {
            background: #fff;
            padding: 8px;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            */ border: 1px solid #dee2e6;
        }

        .stat-card {
            background: #ffffff;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            gap: 1rem;
            position: absolute;
            bottom: -40px;
            left: -40px;
            width: fit-content;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            background-color: var(--bs-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .features-section {
            padding: 80px 0;
            background-color: #e9f6fd;
        }

        .feature-card {
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 1rem;
            border: 1px solid #dee2e6;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .feature-icon-box {
            width: 56px;
            height: 56px;
            background-color: #cfe6f2;
            color: var(--bs-primary);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .cta-section {
            padding: 80px 0;
            background-color: var(--bs-primary);
            position: relative;
            overflow: hidden;
        }

        .cta-content {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            padding: 4rem 2rem;
            border-radius: 50rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
        }

        @media (max-width: 991.98px) {
            .cta-content {
                border-radius: 2rem;
            }

            .display-large {
                font-size: 2.5rem;
            }
        }

        footer {
            padding: 3rem 0;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        .footer-link {
            font-size: 0.875rem;
            color: #6c757d;
            text-decoration: underline;
            text-underline-offset: 4px;
            margin-left: 1.5rem;
        }

        .footer-link:hover {
            color: var(--bs-primary);
        }

        .material-symbols-outlined {
            vertical-align: middle;
        }


        /* ── Background ── */
        .bg-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            opacity: .3;
            pointer-events: none;
            z-index: 0;
        }

        .blob-1 {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, #1565C0, transparent);
            top: -200px;
            left: -150px;
        }

        .blob-2 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, #26D0CE, transparent);
            bottom: -100px;
            right: -100px;
        }

        .blob-3 {
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, #26D0CE33, transparent);
            top: 40%;
            left: 15%;
        }

        .grid-lines {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(255, 255, 255, .025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .025) 1px, transparent 1px);
            background-size: 55px 55px;
        }

        /* ── Navbar ── */
        /* .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(13, 27, 75, .75);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            padding: 16px 0;
        }

        .navbar-brand {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--teal) !important;
            text-decoration: none;
        }

        .navbar-brand span {
            color: #fff;
        }

        .nav-link {
            color: rgba(255, 255, 255, .6) !important;
            font-weight: 500;
            font-size: .88rem;
            padding: 8px 16px !important;
            border-radius: 8px;
            transition: all .2s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #fff !important;
            background: rgba(255, 255, 255, .07);
        }

        .btn-nav-outline {
            background: transparent;
            border: 1.5px solid rgba(255, 255, 255, .25);
            color: #fff;
            font-weight: 600;
            font-size: .85rem;
            padding: 8px 20px;
            border-radius: 10px;
            text-decoration: none;
            transition: all .2s;
        } */

        .btn-nav-outline:hover {
            border-color: var(--teal);
            color: var(--teal);
        }

        .btn-nav-solid {
            background: linear-gradient(135deg, #1565C0, #1A2980);
            color: #fff;
            font-weight: 700;
            font-size: .85rem;
            padding: 8px 20px;
            border-radius: 10px;
            text-decoration: none;
            border: none;
            box-shadow: 0 4px 14px rgba(21, 101, 192, .4);
            transition: all .2s;
        }

        .btn-nav-solid:hover {
            transform: translateY(-1px);
            color: #fff;
            box-shadow: 0 8px 20px rgba(21, 101, 192, .5);
        }

        /* ── Buttons ── */
        .btn-primary-pub {
            background: linear-gradient(135deg, #1565C0, #1A2980);
            color: #fff;
            font-weight: 700;
            font-size: .95rem;
            padding: 13px 30px;
            border-radius: 12px;
            border: none;
            box-shadow: 0 6px 20px rgba(21, 101, 192, .5);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: all .25s;
            font-family: 'Space Grotesk', sans-serif;
        }

        .btn-primary-pub:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(21, 101, 192, .6);
            color: #fff;
        }

        .btn-outline-pub {
            background: rgba(255, 255, 255, .07);
            border: 1.5px solid rgba(255, 255, 255, .2);
            color: #fff;
            font-weight: 600;
            font-size: .95rem;
            padding: 13px 30px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: all .25s;
            font-family: 'Space Grotesk', sans-serif;
        }

        .btn-outline-pub:hover {
            border-color: var(--teal);
            color: var(--teal);
            background: rgba(38, 208, 206, .08);
        }

        /* ── Glass card ── */
        .glass-card {
            background: rgba(255, 255, 255, 0.748);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 24px;
        }

        /* ── Section badge ── */
        .section-badge {
            display: inline-block;
            background: rgba(38, 208, 206, .1);
            border: 1px solid rgba(38, 208, 206, .25);
            color: var(--teal);
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 50px;
            margin-bottom: 16px;
        }

        /* ── Section title ── */
        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(1.8rem, 3.5vw, 2.8rem);
            font-weight: 800;
            letter-spacing: -1px;
            line-height: 1.15;
        }

        /* ── Status dot ── */
        .status-dot {
            width: 8px;
            height: 8px;
            background: var(--teal);
            border-radius: 50%;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(38, 208, 206, .4);
            }

            50% {
                box-shadow: 0 0 0 6px rgba(38, 208, 206, 0);
            }
        }

        /* ── Form inputs ── */
        .form-label-pub {
            font-size: .78rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .6);
            letter-spacing: .4px;
            text-transform: uppercase;
            margin-bottom: 8px;
            display: block;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, .35);
            font-size: .95rem;
            pointer-events: none;
        }

        .form-input-pub {
            width: 100%;
            background: rgba(255, 255, 255, .08);
            border: 1.5px solid rgba(255, 255, 255, .15);
            border-radius: 12px;
            color: #fff;
            font-family: 'Space Grotesk', sans-serif;
            font-size: .9rem;
            padding: 12px 14px 12px 42px;
            outline: none;
            transition: all .25s;
        }

        .form-input-pub::placeholder {
            color: rgba(255, 255, 255, .3);
        }

        .form-input-pub:focus {
            background: rgba(255, 255, 255, .12);
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(38, 208, 206, .2);
        }

        .form-input-pub.is-error {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .15);
        }

        /* ── Alert ── */
        .alert-pub-err {
            background: rgba(239, 68, 68, .12);
            border: 1px solid rgba(239, 68, 68, .3);
            color: #fca5a5;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: .82rem;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
        }

        .alert-pub-success {
            background: rgba(34, 197, 94, .1);
            border: 1px solid rgba(34, 197, 94, .25);
            color: #4ade80;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: .82rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── Divider ── */
        .divider-pub {
            height: 1px;
            background: rgba(255, 255, 255, .08);
            margin: 24px 0;
        }

        /* ── Tip box ── */
        .tip-box {
            background: rgba(38, 208, 206, .07);
            border: 1px solid rgba(38, 208, 206, .18);
            border-radius: 12px;
            padding: 14px 16px;
            font-size: .8rem;
            color: rgba(255, 255, 255, .55);
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .tip-box i {
            color: var(--teal);
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* ── Footer ── */
        .footer-pub {
            position: relative;
            z-index: 1;
            background: rgba(0, 0, 0, .3);
            border-top: 1px solid rgba(255, 255, 255, .07);
            padding: 20px 0;
            margin-top: 60px;
            font-size: .78rem;
            color: rgba(255, 255, 255, .25);
            text-align: center;
        }

        /* ── Fade anim ── */
        .fade-up {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .6s ease, transform .6s ease;
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: var(--navy);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(38, 208, 206, .4);
            border-radius: 50px;
        }

        /* track */
        .page-wrap {
            position: relative;
            z-index: 1;
            min-height: calc(100vh - 130px);
            display: flex;
            align-items: center;
            padding: 80px 0;
        }

        .search-card {
            padding: 48px 40px;
        }

        .card-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #1565C0, #26D0CE);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7rem;
            color: #fff;
            box-shadow: 0 8px 24px rgba(21, 101, 192, .5);
            margin: 0 auto 24px;
        }

        .card-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.7rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 6px;
        }

        .card-sub {
            text-align: center;
            font-size: .88rem;
            color: rgba(255, 255, 255, .5);
            margin-bottom: 32px;
        }

        .btn-track {
            width: 100%;
            background: linear-gradient(135deg, #1565C0, #1A2980);
            color: #fff;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: .95rem;
            padding: 13px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 6px 20px rgba(21, 101, 192, .4);
            transition: all .25s;
            margin-top: 18px;
        }

        .btn-track:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(21, 101, 192, .5);
        }

        .example-chip {
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .12);
            color: rgba(255, 255, 255, .6);
            font-size: .75rem;
            padding: 5px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Space Grotesk', sans-serif;
            transition: all .2s;
        }

        .example-chip:hover {
            border-color: var(--teal);
            color: var(--teal);
        }

        /* Result */
        .result-card {
            padding: 36px;
            display: none;
        }

        .result-card.show {
            display: block;
            animation: fadeSlide .4s ease;
        }

        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateY(16px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .ticket-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 28px;
        }

        .ticket-id {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
        }

        .ticket-sub {
            font-size: .82rem;
            color: rgba(255, 255, 255, .45);
            margin-top: 4px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: .78rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .s-0 {
            background: rgba(249, 115, 22, .15);
            color: #f97316;
            border: 1px solid rgba(249, 115, 22, .3);
        }

        .s-1 {
            background: rgba(59, 130, 246, .15);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, .3);
        }

        .s-2 {
            background: rgba(168, 85, 247, .15);
            color: #c084fc;
            border: 1px solid rgba(168, 85, 247, .3);
        }

        .s-3 {
            background: rgba(245, 197, 24, .15);
            color: #fbbf24;
            border: 1px solid rgba(245, 197, 24, .3);
        }

        .s-4 {
            background: rgba(34, 197, 94, .15);
            color: #4ade80;
            border: 1px solid rgba(34, 197, 94, .3);
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 28px;
        }

        .info-item {
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 12px;
            padding: 14px 16px;
        }

        .info-item .lbl {
            font-size: .68rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .35);
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 5px;
        }

        .info-item .val {
            font-size: .88rem;
            font-weight: 600;
        }

        .sec-label {
            font-size: .72rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .35);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 16px;
        }

        .steps-track {
            position: relative;
            padding-bottom: 4px;
        }

        .steps-track::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            width: 2px;
            height: calc(100% - 40px);
            background: rgba(255, 255, 255, .08);
        }

        .line-fill {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 2px;
            background: linear-gradient(180deg, var(--teal), #1565C0);
            transition: height .8s cubic-bezier(.4, 0, .2, 1);
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding-bottom: 24px;
            position: relative;
        }

        .step-item:last-child {
            padding-bottom: 0;
        }

        .step-dot {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
            transition: all .4s;
        }

        .step-dot.done {
            background: linear-gradient(135deg, var(--teal), #1565C0);
            box-shadow: 0 4px 14px rgba(38, 208, 206, .4);
        }

        .step-dot.active {
            background: linear-gradient(135deg, #1565C0, #1A2980);
            box-shadow: 0 4px 14px rgba(21, 101, 192, .5);
            animation: stepPulse 2s infinite;
        }

        .step-dot.idle {
            background: rgba(255, 255, 255, .07);
            border: 1.5px solid rgba(255, 255, 255, .1);
        }

        @keyframes stepPulse {

            0%,
            100% {
                box-shadow: 0 4px 14px rgba(21, 101, 192, .5)
            }

            50% {
                box-shadow: 0 4px 20px rgba(21, 101, 192, .8), 0 0 0 6px rgba(21, 101, 192, .15)
            }
        }

        .step-name {
            font-size: .9rem;
            font-weight: 700;
        }

        .step-name.idle {
            color: rgba(255, 255, 255, .3);
        }

        .step-date {
            font-size: .72rem;
            color: rgba(255, 255, 255, .35);
            margin-top: 3px;
        }

        .step-desc {
            font-size: .77rem;
            color: rgba(255, 255, 255, .4);
            margin-top: 4px;
            line-height: 1.5;
        }

        .agent-row {
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 14px;
            padding: 16px;
        }

        .agent-ava {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1565C0, #26D0CE);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .9rem;
            flex-shrink: 0;
        }

        .agent-name {
            font-size: .9rem;
            font-weight: 700;
        }

        .agent-role {
            font-size: .72rem;
            color: rgba(255, 255, 255, .4);
        }

        .line-separator {
            width: 80px;
            height: 4px;
            background: #0d6efd;
            margin: 0 auto;
            border-radius: 50px;
        }
    </style>

    @stack('styles')
</head>



ini head buat dcomponent/app

<body>

    {{-- Background decorations --}}
    <div class="grid-lines"></div>
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>
    <div class="bg-blob blob-3"></div>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-md fixed-top">
        <div class="container px-4">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <!-- Tambahkan tag img di sini -->
                <img src="{{ asset('images/logo-helpdesk.png') }}" alt="Logo" width="56" height="56"
                    class="d-inline-block align-top me-2">
                Helpdesk IT
            </a>

            <button class="navbar-toggler" data-bs-target="#navbarNav" data-bs-toggle="collapse" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-bold {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold {{ request()->routeIs('track') ? 'active' : '' }}"
                            href="{{ route('track') }}">Cek Status Tiket</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('faq.public') ? 'active' : '' }}"
                            href="{{ route('faq.public') }}">FAQ</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('login') }}" class="btn btn-primary fw-bold">Login</a>
                </div>
            </div>
        </div>
    </nav>

    {{-- PAGE CONTENT --}}
    @yield('content')

    {{-- FOOTER --}}
    <!-- Footer -->
    <footer>
        <div class="container px-4">
            <div class="row align-items-center">

                <div class="col-md-6 text-center text-md-start mb-4 mb-md-0">
                    <div class="h5 fw-bold mb-1">IT Helpdesk</div>
                    <p class="small text-muted mb-0">
                        © {{ date('Y') }} IT Helpdesk.
                    </p>
                </div>

                <div class="col-md-6 text-center text-md-end">
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-end">
                        <a class="footer-link" href="#">Privacy Policy</a>
                        <a class="footer-link" href="#">Terms of Service</a>
                        <a class="footer-link" href="#">Security</a>
                        <a class="footer-link" href="#">API Documentation</a>
                        <a class="footer-link" href="#">Help Desk</a>
                    </div>
                </div>

            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Fade-up observer --}}

    @stack('scripts')
</body>

</html>
