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
        <!-- Admin Access -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.index') }}">
                <i class="mdi mdi-view-dashboard menu-icon"></i>
                <span class="menu-title">Dashboard Admin</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('usermanage.index') }}">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">User Management</span>
            </a>
        </li>
        @endif
        @if(Auth::user()->jabatan === 'karyawan')
        <!-- Karyawan Access -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.index') }}">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Dashboard Karyawan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('jenispengiriman.index') }}">
                <i class="mdi mdi-truck-delivery menu-icon"></i>
                <span class="menu-title">Delivery Types</span>
            </a>
        </li>
        @endif
        @if(in_array(Auth::user()->jabatan, ['kasir', 'karyawan']))
        <!-- Kasir & Karyawan Access -->
        
        <li class="nav-item">
            <a class="nav-link" href="{{ route('metodebayar.index') }}">
                <i class="mdi mdi-credit-card menu-icon"></i>
                <span class="menu-title">Payment Methods</span>
            </a>
        </li>
        
        @endif
        @if(Auth::user()->jabatan === 'kurir')
        <!-- Kurir Access -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('kurir.index') }}">
                <i class="mdi mdi-bike menu-icon"></i>
                <span class="menu-title">Dashboard Kurir</span>
            </a>
        </li>
        @endif
        
        @if(in_array(Auth::user()->jabatan, ['kasir', 'karyawan', 'kurir', 'pemilik']))
        <!-- Kasir, Karyawan & Kurir Access -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('penjualan.index') }}">
                <i class="mdi mdi-cart-outline menu-icon"></i>
                <span class="menu-title">Orders</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pengiriman.index') }}">
                <i class="mdi mdi-truck-fast menu-icon"></i>
                <span class="menu-title">Shipping</span>
            </a>
        </li>
        @endif

        

        @if(Auth::user()->jabatan === 'pemilik')
        <!-- Pemilik Access -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pemilik.index') }}">
                <i class="mdi mdi-chart-bar menu-icon"></i>
                <span class="menu-title">Dashboard Pemilik</span>
            </a>
        </li>
        @endif

        @if(Auth::user()->jabatan === 'apoteker')
        <!-- Apoteker Access -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('apoteker.index') }}">
                <i class="mdi mdi-pill menu-icon"></i>
                <span class="menu-title">Dashboard Apoteker</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#product-menu">
                <i class="mdi mdi-medical-bag menu-icon"></i>
                <span class="menu-title">Products</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="product-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('jenis.index') }}">
                            <i class="mdi mdi-pill menu-icon"></i>
                            Jenis Obat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('obat.index') }}">
                            <i class="mdi mdi-medical-bag menu-icon"></i>
                            Obat
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('distributor.index') }}">
                <i class="mdi mdi-truck menu-icon"></i>
                <span class="menu-title">Distributor</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pembelian.index') }}">
                <i class="mdi mdi-cart menu-icon"></i>
                <span class="menu-title">Purchase</span>
            </a>
        </li>
        @endif

        @if(Auth::user()->jabatan === 'kasir')
        <!-- Kasir Access -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('kasir.index') }}">
                <i class="mdi mdi-cash-register menu-icon"></i>
                <span class="menu-title">Dashboard Kasir</span>
            </a>
        </li>
        @endif

        
    </ul>
</nav>