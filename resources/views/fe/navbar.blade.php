<div class="site-navbar bg-white py-2">
    <div class="search-wrap">
        <div class="container">
            <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
            <form action="{{ route('products.index') }}" method="get">
                <input type="text" name="search" class="form-control" placeholder="Search keyword and hit enter..." value="{{ request('search') }}">
            </form>
        </div>
    </div>

    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <div class="logo">
                <div class="site-logo">
                    <a href="/" class="js-logo-clone">Pharmal</a>
                </div>
            </div>
            <div class="main-nav d-none d-lg-block">
                <nav class="site-navigation text-right text-md-center" role="navigation">
                    <ul class="site-menu js-clone-nav d-none d-lg-block">
                        <li class="{{ request()->is('/') ? 'active' : '' }}">
                            <a href="/">Home</a>
                        </li>
                        <li class="{{ request()->is('about*') ? 'active' : '' }}">
                            <a href="/about">About</a>
                        </li>
                        <li class="{{ request()->is('products*') ? 'active' : '' }}">
                            <a href="/products">Products</a>
                        </li>
                        @if(Auth::guard('pelanggan')->check())
                        <li class="{{ request()->is('pesanan*') ? 'active' : '' }}">
                            <a href="/pesanan">Orders</a>
                        </li>
                        <li class="has-children {{ request()->is('profile*') ? 'active' : '' }}">
                            <a href="/profile">Profile</a>
                            <ul class="dropdown">
                                <li style="display: flex; flex-direction: column; align-items: center; padding: 10px;">
                                    <div class="profile-image" style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; background-color: #f0f0f0; margin-bottom: 8px;">
                                        @if(Auth::guard('pelanggan')->user()->foto)
                                        <img src="{{ asset('storage/' . Auth::guard('pelanggan')->user()->foto) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                        <span style="display: flex; align-items: center; justify-content: center; height: 100%; font-size: 1rem; color: #888;">No Image</span>
                                        @endif
                                    </div>
                                    <div class="profile-info text-center">
                                        <p style="margin: 0; font-weight: bold;">{{ Auth::guard('pelanggan')->user()->nama_pelanggan }}</p>
                                        <p style="margin: 0; font-size: 0.9rem; color: #666;">{{ Auth::guard('pelanggan')->user()->email }}</p>
                                    </div>
                                </li>
                                <li class="{{ request()->is('profile') ? 'active' : '' }}">
                                    <a href="/profile">Profile</a>
                                </li>
                                <li><a href="{{ route('auth.logoutpelanggan') }}">LogOut</a></li>
                            </ul>
                        </li>
                        @endif
                        <li class="{{ request()->is('contact*') ? 'active' : '' }}">
                            <a href="/contact">Contact</a>
                        </li>

                        @if(Auth::User())
                        <li class="has-children {{ request()->is('admin*') ? 'active' : '' }}">
                            <a href="">{{ ucfirst(Auth::user()->jabatan) }}</a>
                            <ul class="dropdown">
                                <li class="{{ request()->is('admin') ? 'active' : '' }}">
                                    <a href="/admin">Dashboard</a>
                                </li>
                                <li><a href="{{ route('auth.logout') }}">LogOut</a></li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>

            <!-- Icons dan Foto Profil -->
            <div class="d-flex align-items-center gap-3">
                <div class="icons d-flex align-items-center">
                    <a href="#" class="icons-btn d-inline-block js-search-open"><span class="icon-search"></span></a>
                </div>
                @if(Auth::guard('pelanggan')->check())
                <a href="/keranjang" class="icons-btn d-inline-block bag ">
                    <span class="icon-shopping-cart"></span>
                    @if(Auth::guard('pelanggan')->check())
                        <span class="number">{{ App\Http\Controllers\KeranjangController::getCartCount() }}</span>
                    @else
                        <span class="number">0</span>
                    @endif
                </a>
                @elseif(Auth::User())

                @else
                <div class="main-nav d-none d-lg-block">
                    <nav class="site-navigation text-right text-md-center" role="navigation">
                        <ul class="site-menu js-clone-nav d-none d-lg-block">
                            <li><a href="{{ route('auth.loginpelanggan', ['panel' => 'login']) }}">Login</a></li>
                            <li><a href="{{ route('auth.registerpelanggan') }}">Register</a></li>

                        </ul>
                    </nav>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>