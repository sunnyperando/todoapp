<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ config('app.name', 'TaskFlow') }} — @yield('title', 'Dashboard')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    {{-- Bootstrap CSS --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    />

    <style>
        * {
        transition: background-color 0.2s ease, color 0.2s ease;
            }
        body { background-color: #f4f6f9; }

        /* Sidebar */
        #sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #1e2a38;
            position: fixed;
            top: 0; left: 0;
            overflow-y: auto;
            transition: width 0.2s;
            z-index: 1000;
        }
        #sidebar .brand {
            padding: 1.25rem 1.5rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        #sidebar .nav-link {
            color: #adb5bd;
            padding: 0.65rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            transition: background 0.15s, color 0.15s;
            border-radius: 0;
        }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.08);
            color: #fff;
        }
        #sidebar .nav-section {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #6c757d;
            padding: 1rem 1.5rem 0.25rem;
        }

        /* Main content offset */
        #main-wrapper {
            margin-left: 250px;
        }

        /* Top Navbar */
        #topbar {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* Responsive collapse */
        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                left: -250px; /* hide off screen */
                top: 0;
                width: 250px;
                height: 100%;
                z-index: 1000;
                transition: left 0.3s ease;
            }

                #sidebar .brand {
                font-size: 1.1rem;
            }

            #sidebar .nav-link {
                padding: 0.8rem 1.5rem;
                font-size: 0.95rem;
            }

            #sidebar.show {
                left: 0; /* slide in */
            }

            #main-wrapper {
                margin-left: 0 !important;
            }
        }
        /* ================= DARK MODE ================= */

        body[data-theme="dark"] {
            background-color: #0f172a;
            color: #e5e7eb;
        }

        /* Sidebar */
        body[data-theme="dark"] #sidebar {
            background-color: #020617;
        }

        body[data-theme="dark"] #sidebar .nav-link {
            color: #9ca3af;
        }

        body[data-theme="dark"] #sidebar .nav-link:hover,
        body[data-theme="dark"] #sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.08);
            color: #fff;
        }

        /* Topbar */
        body[data-theme="dark"] #topbar {
            background-color: #020617;
            border-bottom: 1px solid #1f2937;
        }

        /* Cards */
        body[data-theme="dark"] .card {
            background-color: #1e293b;
            color: #e5e7eb;
            border-color: #334155;
        }

        /* Inputs */
        body[data-theme="dark"] input,
        body[data-theme="dark"] textarea,
        body[data-theme="dark"] select {
            background-color: #1e293b;
            color: #fff;
            border-color: #334155;
        }

        /* Tables */
        body[data-theme="dark"] table {
            color: #e5e7eb;
        }

        body[data-theme="dark"] .table {
            --bs-table-bg: #1e293b;
        }

        /* Modals */
        body[data-theme="dark"] .modal-content {
            background-color: #1e293b;
            color: #fff;
        }

        /* Dropdown */
        body[data-theme="dark"] .dropdown-menu {
            background-color: #1e293b;
            color: #fff;
        }
        /* Fix card text */
        body[data-theme="dark"] .card,
        body[data-theme="dark"] .card * {
            color: #e5e7eb !important;
        }

        body[data-theme="dark"] .text-muted {
            color: #9ca3af !important;
        }

        body[data-theme="dark"] .progress {
            background-color: #334155;
        }

        body[data-theme="dark"] .progress-bar {
            background-color: #22c55e;
        }

        body[data-theme="dark"] h1,
        body[data-theme="dark"] h2,
        body[data-theme="dark"] h3,
        body[data-theme="dark"] h4,
        body[data-theme="dark"] h5 {
            color: #f9fafb;
        }

        body[data-theme="dark"] #topbar {
            color: #e5e7eb;
        }

        /* Dropdown fix */
        body[data-theme="dark"] .dropdown-menu {
            background-color: #1e293b;
            border: 1px solid #334155;
        }

        body[data-theme="dark"] .dropdown-item {
            color: #e5e7eb;
        }

        body[data-theme="dark"] .dropdown-item:hover {
            background-color: #334155;
            color: #fff;
        }

        body[data-theme="dark"] .dropdown-divider {
            border-color: #334155;
        }

        /* Fix navbar username in dark mode */
        body[data-theme="dark"] #topbar .dropdown-toggle span {
            color: #f9fafb !important; /* bright white */
        }

        /* Sidebar overlay (mobile only) */
        #sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;

            background: rgba(0, 0, 0, 0.4);

            opacity: 0;
            visibility: hidden;

            transition: 0.3s ease;
            z-index: 1000;
        }

        /* When active */
        #sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Sidebar */
        #sidebar {
            z-index: 1050;
        }

        /* Overlay */
        #sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;

            background: rgba(0,0,0,0.4);

            opacity: 0;
            visibility: hidden;

            transition: 0.3s;
            z-index: 1040; /* LOWER than sidebar */
        }

        /* When active */
        #sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }
    </style>

    @stack('styles')
</head>
<body data-theme="light">

{{-- ===================== SIDEBAR ===================== --}}
@include('layouts.sidebar')

{{-- Sidebar Overlay (for mobile) --}}
<div id="sidebar-overlay" onclick="toggleSidebar()"></div>

{{-- ===================== MAIN WRAPPER ===================== --}}
<div id="main-wrapper">

    {{-- Top Navbar --}}
    @include('layouts.navbar')

    {{-- Page Content --}}
    <main class="p-4">

        {{-- Page Header --}}
        @hasSection('page-header')
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 small">
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
                <div>@yield('page-actions')</div>
            </div>
        @endif

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

<script>
    function toggleTheme() {
        const current = document.body.getAttribute('data-theme');

        if (current === 'dark') {
            document.body.setAttribute('data-theme', 'light');
            localStorage.setItem('theme', 'light');
        } else {
            document.body.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
        }
    }

    // Load saved theme
        document.addEventListener('DOMContentLoaded', () => {
            const saved = localStorage.getItem('theme') || 'light';
            document.body.setAttribute('data-theme', saved);
        });

    function updateDateTime() {
        const now = new Date();

        const formatted = now.toLocaleString(undefined, {
            weekday: 'short',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

        const el = document.getElementById('liveDate');
        if (el) el.textContent = formatted;
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }

</script>
</body>
</html>