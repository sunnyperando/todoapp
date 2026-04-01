<nav id="sidebar" class="d-flex flex-column p-3">

    {{-- BRAND --}}
    <div class="brand mb-4 fs-4 fw-bold text-white">
        <i class="bi bi-kanban-fill me-2"></i> TaskFlow
    </div>
    @auth
    <ul class="nav nav-pills flex-column mb-auto">

        {{-- MAIN --}}
        <li class="nav-section text-uppercase small mb-2">Main</li>

        <li class="nav-item">
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : 'text-white' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.projects.index') }}"
               class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : 'text-white' }}">
                <i class="bi bi-folder me-2"></i> Projects
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.tasks.index') }}"
               class="nav-link {{ request()->routeIs('admin.tasks.*') ? 'active' : 'text-white' }}">
                <i class="bi bi-list-check me-2"></i> Tasks
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('profile.show') }}"
               class="nav-link {{ request()->routeIs('profile.*') ? 'active' : 'text-white' }}">
                <i class="bi bi-person-circle me-2"></i> Profile
            </a>
        </li>


        @if(Auth::user()->isAdmin())
        {{-- ADMIN --}}
        <li class="nav-section text-uppercase small mt-4 mb-2">Admin</li>

        <li class="nav-item">
            <a href="{{ route('admin.users.index') }}"
               class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : 'text-white' }}">
                <i class="bi bi-people me-2"></i> Users
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.roles.index') }}"
               class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : 'text-white' }}">
                <i class="bi bi-shield-lock me-2"></i> Roles
            </a>
        </li>
        @endif
        @endauth

    </ul>
</nav>