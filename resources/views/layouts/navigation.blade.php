<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold text-primary" href="{{ route('dashboard') }}">
            <x-application-logo class="d-inline-block align-text-top" style="height: 28px;" />
            {{ config('app.name', 'Laravel') }}
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-semibold text-primary' : '' }}"
                       href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('documents.*') ? 'active fw-semibold text-primary' : '' }}"
                       href="{{ route('documents.index') }}">
                        <i class="bi bi-folder2-open me-1"></i> Documents
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('documents.logs') ? 'active fw-semibold text-primary' : '' }}"
                       href="{{ route('documents.logs') }}">
                        <i class="bi bi-clock-history me-1"></i> My Logs
                    </a>
                </li>
                @if(Auth::user() && Auth::user()->is_admin)
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.*') ? 'active fw-semibold text-primary' : '' }}"
                       href="{{ route('admin.documents') }}">
                        <i class="bi bi-shield-lock me-1"></i> Admin Dashboard
                    </a>
                </li>
                @endif

                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                       role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-lines-fill me-2"></i> Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2"></i> Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
