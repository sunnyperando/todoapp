<div id="topbar" class="d-flex justify-content-between align-items-center">

    {{-- Mobile sidebar toggle --}}
    <button class="btn btn-sm btn-outline-secondary d-md-none"
            onclick="toggleSidebar()">
        <i class="bi bi-list fs-5"></i>
    </button>
    @auth
    {{-- Search bar (optional) --}}
    <div class="d-none d-md-block">
        <form action="{{ route('admin.search') }}" method="GET">
            <div class="input-group input-group-sm" style="width:260px">
                <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="search" name="q" class="form-control bg-light border-start-0"
                    placeholder="Search tasks & projects...">
            </div>
        </form>
    </div>


    {{-- Right side --}}
    <div class="d-flex align-items-center gap-3">

    <span id="liveDate" class="text-muted small d-none d-md-inline"></span>

        {{-- User dropdown --}}
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle"
               data-bs-toggle="dropdown" aria-expanded="false">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                     style="width:34px;height:34px;font-size:0.85rem;font-weight:600">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span class="d-none d-md-inline small fw-semibold text-body">
                    {{ Auth::user()->name }}
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                        <i class="bi bi-person me-2"></i>My Profile
                    </a>
                </li>

                <li><hr class="dropdown-divider"></li>

                    <!-- Quick Actions -->
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.tasks.create') }}">
                            <i class="bi bi-plus-square me-2"></i> Add Task
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ route('admin.projects.create') }}">
                            <i class="bi bi-folder-plus me-2"></i> Add Project
                        </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                <!-- THEME -->
                <li>
                    <button class="dropdown-item" onclick="toggleTheme()">
                        <i class="bi bi-moon me-2"></i> Toggle Theme
                    </button>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        @endauth

        @guest
        <div class="ms-auto d-flex align-items-center gap-3">
            <div class="d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
            </div>
        </div>
        @endguest
    </div>
</div>