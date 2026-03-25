<nav id="sidebar">
    <div class="brand">
        <i class="bi bi-grid-3x3-gap-fill me-2"></i>MyApp
    </div>

    <ul class="nav flex-column mt-2">

        {{-- MAIN --}}
        <li class="nav-section">Main</li>

        <li class="nav-item">
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('profile.show') }}"
               class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> My Profile
            </a>
        </li>

    {{-- ADMIN --}}
    <li class="nav-section">Admin</li>

    <li class="nav-item">
        <a href="{{ route('admin.users.index') }}"
        class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Users
        </a>
    </li>

    {{-- TEMP DISABLED (Part 3 Task 2 not done yet) --}}
    {{-- 
    <li class="nav-item">
        <a href="{{ route('admin.roles.index') }}"
        class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i> Roles Management
        </a>
    </li>
    --}}

    {{-- STORE (not built yet) --}}
    {{--
    <li class="nav-section">Store</li>

    <li class="nav-item">
        <a href="{{ route('admin.products.index') }}">
            <i class="bi bi-box-seam"></i> Products
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.orders.index') }}">
            <i class="bi bi-cart3"></i> Orders
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.payments.index') }}">
            <i class="bi bi-credit-card"></i> Payments
        </a>
    </li>
    --}}

    </ul>
</nav>