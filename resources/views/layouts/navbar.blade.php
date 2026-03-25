<div id="topbar" class="d-flex justify-content-between align-items-center">

    {{-- Mobile sidebar toggle --}}
    <button class="btn btn-sm btn-outline-secondary d-md-none"
            onclick="document.getElementById('sidebar').classList.toggle('show')">
        <i class="bi bi-list fs-5"></i>
    </button>

    {{-- Search bar (optional) --}}
    <div class="d-none d-md-block">
        <div class="input-group input-group-sm" style="width:260px">
            <span class="input-group-text bg-light border-end-0">
                <i class="bi bi-search text-muted"></i>
            </span>
            <input type="search" class="form-control bg-light border-start-0"
                   placeholder="Search...">
        </div>
    </div>

    {{-- Right side --}}
    <div class="d-flex align-items-center gap-3">

        {{-- Notifications (placeholder) --}}
        <button class="btn btn-sm btn-light position-relative">
            <i class="bi bi-bell fs-5"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                  style="font-size:0.6rem">3</span>
        </button>

        {{-- User dropdown --}}
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle"
               data-bs-toggle="dropdown" aria-expanded="false">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                     style="width:34px;height:34px;font-size:0.85rem;font-weight:600">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span class="d-none d-md-inline small fw-semibold text-dark">
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

    </div>
</div>