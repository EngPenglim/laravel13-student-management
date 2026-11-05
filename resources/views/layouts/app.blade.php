<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Library Management System') - SETIC Laravel 13</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-emerald: #059669;
            --primary-dark: #064e3b;
            --primary-light: #10b981;
            --teal-accent: #0d9488;
            --gold-accent: #f59e0b;
            --surface-bg: #f3f6f4;
            --card-border: #e2e8f0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--surface-bg);
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: 'Outfit', sans-serif;
        }

        /* Top Navigation - Emerald Themed */
        .navbar-custom {
            background: #ffffff;
            border-bottom: 2px solid #e6f0eb;
            box-shadow: 0 4px 20px -5px rgba(6, 78, 59, 0.06);
        }
        .navbar-brand-badge {
            background: linear-gradient(135deg, #064e3b, #059669 60%, #0d9488);
            color: #ffffff;
            padding: 8px 14px;
            border-radius: 10px;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .nav-link.active-link {
            color: var(--primary-emerald) !important;
            font-weight: 700;
            position: relative;
        }
        .nav-link.active-link::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 8px;
            right: 8px;
            height: 3px;
            background: var(--primary-emerald);
            border-radius: 4px;
        }

        /* Header Card - Deep Emerald & Forest Teal Gradient */
        .header-gradient-card {
            background: linear-gradient(135deg, #04382a 0%, #064e3b 35%, #047857 70%, #0d9488 100%);
            color: #ffffff;
            border-radius: 20px;
            padding: 32px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 14px 30px -8px rgba(6, 78, 59, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .header-gradient-card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        /* Stat Glass Cards - Gold & Emerald Accented */
        .stat-glass-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 14px;
            padding: 16px 20px;
            color: #ffffff;
            text-align: center;
            transition: transform 0.2s ease, background 0.2s ease;
        }
        .stat-glass-card:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.18);
        }
        .stat-number {
            font-size: 1.9rem;
            font-weight: 800;
            line-height: 1.1;
            font-family: 'Outfit', sans-serif;
            color: #fef08a; /* Soft Gold/Amber accent */
        }
        .stat-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.95);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        /* Content Cards */
        .content-card {
            background: #ffffff;
            border: 1px solid #e5ede7;
            border-radius: 18px;
            box-shadow: 0 4px 16px -2px rgba(6, 78, 59, 0.05);
        }

        /* Primary Buttons - Emerald Gradient */
        .btn-primary {
            background: linear-gradient(135deg, #059669, #047857) !important;
            border-color: #047857 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(5, 150, 105, 0.28);
            transition: all 0.2s ease;
        }
        .btn-primary:hover, .btn-primary:focus {
            background: linear-gradient(135deg, #047857, #064e3b) !important;
            border-color: #064e3b !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(5, 150, 105, 0.38);
        }

        .btn-outline-primary {
            color: var(--primary-emerald) !important;
            border-color: var(--primary-emerald) !important;
        }
        .btn-outline-primary:hover {
            background: var(--primary-emerald) !important;
            color: #fff !important;
        }

        /* Inputs Focus Ring - Emerald */
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-emerald) !important;
            box-shadow: 0 0 0 0.25rem rgba(5, 150, 105, 0.2) !important;
        }

        /* Category Badges - Forest Green */
        .category-badge {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Status Pills */
        .status-badge-available {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #6ee7b7;
            font-weight: 700;
        }
        .status-badge-borrowed {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
            font-weight: 700;
        }
        .status-badge-reserved {
            background: #fdf2f8;
            color: #be185d;
            border: 1px solid #fbcfe8;
            font-weight: 700;
        }

        /* Action Buttons */
        .action-btn {
            width: 34px;
            height: 34px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        .btn-view {
            background: #f0fdf4;
            color: #047857;
            border: 1px solid #bbf7d0;
        }
        .btn-view:hover {
            background: #047857;
            color: #fff;
        }
        .btn-edit {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
        }
        .btn-edit:hover {
            background: #b45309;
            color: #fff;
        }
        .btn-delete {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        .btn-delete:hover {
            background: #dc2626;
            color: #fff;
        }

        .footer-note {
            margin-top: auto;
            padding: 24px 0;
            text-align: center;
            font-size: 0.85rem;
            color: #64748b;
            border-top: 1px solid #e5ede7;
            background: #ffffff;
        }
    </style>
    @yield('styles')
</head>
<body>
    @auth
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-dark" href="{{ route('books.index') }}">
                <span class="navbar-brand-badge">
                    <i class="bi bi-book-half"></i> LMS
                </span>
                <span class="brand-font fs-5 text-dark">Library System</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="topNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('books.index') ? 'active-link' : 'text-secondary' }}" href="{{ route('books.index') }}">
                            <i class="bi bi-journal-bookmark-fill me-1"></i> Books Catalog
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('books.create') ? 'active-link' : 'text-secondary' }}" href="{{ route('books.create') }}">
                            <i class="bi bi-plus-circle me-1"></i> Add New Book
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('categories.*') ? 'active-link' : 'text-secondary' }}" href="{{ route('categories.index') }}">
                            <i class="bi bi-tags-fill me-1"></i> Categories
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center small text-secondary bg-light py-1 px-3 rounded-pill border">
                        <i class="bi bi-person-badge-fill fs-6 me-2 text-success"></i>
                        <span class="fw-semibold text-dark">{{ Auth::user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    @endauth

    <!-- Alerts Container -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center bg-success text-white" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div class="fw-medium">{{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                <div class="fw-bold mb-1"><i class="bi bi-exclamation-circle-fill me-1"></i> Please fix the following errors:</div>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-note">
        <div class="container">
            <p class="mb-1 fw-bold text-dark">SETIC Final Project Exam &bull; Laravel 13 Library Management System</p>
            <p class="mb-0 text-muted small">Candidate: <strong>Noun Sinat</strong> &bull; Relational Database &bull; Auth &bull; Filter & Search &bull; CRUD</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
