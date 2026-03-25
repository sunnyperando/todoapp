<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ config('app.name', 'MyApp') }} — @yield('title', 'Dashboard')</title>

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
            z-index: 999;
        }

        /* Responsive collapse */
        @media (max-width: 768px) {
            #sidebar { width: 0; overflow: hidden; }
            #sidebar.show { width: 250px; }
            #main-wrapper { margin-left: 0; }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- ===================== SIDEBAR ===================== --}}
@include('layouts.sidebar')

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
</body>
</html>