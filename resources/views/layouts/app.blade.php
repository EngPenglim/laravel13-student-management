<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Management System') - Laravel 13</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-custom {
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
        .navbar-brand-badge {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
        }
        .header-gradient-card {
            background: linear-gradient(135deg, #3730a3, #4f46e5 60%, #3b82f6);
            color: #ffffff;
            border-radius: 18px;
            padding: 30px;
            position: relative;
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.25);
        }
        .stat-glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 12px;
            padding: 14px 20px;
            color: #ffffff;
            text-align: center;
        }
        .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            line-height: 1.1;
        }
        .stat-label {
            font-size: 0.82rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
            margin-top: 4px;
        }
        .content-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .dept-badge {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #dbeafe;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .action-btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }
        .btn-view {
            background: #e0f2fe;
            color: #0284c7;
            border: 1px solid #bae6fd;
        }
        .btn-view:hover {
            background: #0284c7;
            color: #fff;
        }
        .btn-edit {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }
        .btn-edit:hover {
            background: #059669;
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
            padding: 20px 0;
            text-align: center;
            font-size: 0.85rem;
            color: #64748b;
        }
    </style>
    @yield('styles')
</head>
<body>
    @auth
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-dark" href="{{ route('students.index') }}">
                <span class="navbar-brand-badge"><i class="bi bi-mortarboard-fill me-1"></i> SMS</span>
                <span>Student Management System</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="topNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('students.index') ? 'fw-bold text-primary active' : '' }}" href="{{ route('students.index') }}">
                            <i class="bi bi-people me-1"></i> Student Directory
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('students.create') ? 'fw-bold text-primary active' : '' }}" href="{{ route('students.create') }}">
                            <i class="bi bi-person-plus me-1"></i> Register Student
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('departments.*') ? 'fw-bold text-primary active' : '' }}" href="{{ route('departments.index') }}">
                            <i class="bi bi-building me-1"></i> Departments
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center text-secondary small">
                        <i class="bi bi-person-circle fs-5 me-1 text-primary"></i>
                        <span>{{ Auth::user()->name }} ({{ Auth::user()->email }})</span>
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
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
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
            <p class="mb-1 fw-semibold">SETIC Final Project Exam &bull; Laravel 13 Framework</p>
            <p class="mb-0 text-muted">Relational Database &bull; Auth &bull; Filter & Search &bull; CRUD Operations</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
