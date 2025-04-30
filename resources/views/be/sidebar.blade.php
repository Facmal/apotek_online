<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile border-bottom">
            <a href="#" class="nav-link flex-column">
                <div class="nav-profile-image" style="display: flex; align-items: center; justify-content: center; width: 70px; height: 70px; background-color: #f0f0f0; border-radius: 50%; overflow: hidden;">
                    @if(Auth::user()->img_profile)
                    <img src="{{ asset('storage/' . Auth::user()->img_profile) }}" alt="profile" style="width: 100%; height: 100%; object-fit: cover;" />
                    @else
                    <span style="text-align: center; font-size: 0.550rem; color: #888;">No Image Profile</span>
                    @endif
                </div>
                <div class="nav-profile-text d-flex ml-0 mb-3 flex-column">
                    <span class="font-weight-semibold mb-1 mt-2 text-center" style="font-size: 1.25rem;">
                        {{ Auth::user()->name ?? 'Guest' }}
                    </span>
                    <span class="text-secondary icon-sm text-center" style="font-size: 0.875rem;">
                        {{ ucfirst(Auth::user()->jabatan ?? 'User') }}
                    </span>
                </div>
            </a>
        </li>
        <li class="pt-2 pb-1">
            <span class="nav-item-head">PAGES</span>
        </li>

        @if(Auth::user()->jabatan === 'admin')
        <!-- Admin Dashboard with Dropdown -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#admin-dashboard" aria-expanded="false" aria-controls="admin-dashboard">
                <i class="mdi mdi-compass-outline menu-icon"></i>
                <span class="menu-title">Dashboard</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="admin-dashboard">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">Admin Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/karyawan">Karyawan Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pemilik">Pemilik Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/apoteker">Apoteker Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/kasir">Kasir Dashboard</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/jenis">
                <i class="mdi mdi-pharmacy menu-icon"></i>
                <span class="menu-title">Jenis Obat</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/obat">
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                <span class="menu-title">Obat</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/usermanage">
                <i class="mdi mdi-chart-bar menu-icon"></i>
                <span class="menu-title">Users</span>
            </a>
        </li>
        @else
        <!-- Non-admin users -->
        @if(Auth::user()->jabatan === 'pemilik')
        <li class="nav-item">
            <a class="nav-link" href="/pemilik">
                <i class="mdi mdi-account-tie menu-icon"></i>
                <span class="menu-title">Dashboard Pemilik</span>
            </a>
        </li>
        @endif

        @if(Auth::user()->jabatan === 'apoteker')
        <li class="nav-item">
            <a class="nav-link" href="/apoteker">
                <i class="mdi mdi-flask menu-icon"></i>
                <span class="menu-title">Dashboard Apoteker</span>
            </a>
        </li>
        @endif

        @if(Auth::user()->jabatan === 'kasir')
        <li class="nav-item">
            <a class="nav-link" href="/kasir">
                <i class="mdi mdi-cash-register menu-icon"></i>
                <span class="menu-title">Dashboard Kasir</span>
            </a>
        </li>
        @endif

        @if(Auth::user()->jabatan === 'karyawan')
        <li class="nav-item">
            <a class="nav-link" href="/karyawan">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Dashboard Karyawan</span>
            </a>
        </li>
        @endif

        @if(in_array(Auth::user()->jabatan, ['kasir', 'karyawan']))
        <li class="nav-item">
            <a class="nav-link" href="/jenis">
                <i class="mdi mdi-pharmacy menu-icon"></i>
                <span class="menu-title">Jenis Obat</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/obat">
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                <span class="menu-title">Obat</span>
            </a>
        </li>
        @endif

        @endif
    </ul>
</nav>