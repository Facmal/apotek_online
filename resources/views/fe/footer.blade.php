<footer class="site-footer custom-border-top">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="footer-heading mb-4">Quick Links</h3>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li><a href="/">Home</a></li>
                            <li><a href="/about">About</a></li>
                            <li><a href="/products">Products</a></li>
                            <li><a href="/contact">Contact</a></li>
                        </ul>
                    </div>
                    @if(Auth::guard('pelanggan')->check())
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li><a href="/profile">Profile</a></li>
                            <li><a href="/pesanan">Orders</a></li>
                            <li><a href="/keranjang">Cart</a></li>
                        </ul>
                    </div>
                    @else
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li><a href="{{ route('auth.loginpelanggan', ['panel' => 'login']) }}">Login</a></li>
                            <li><a href="{{ route('auth.registerpelanggan') }}">Register</a></li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="block-5 mb-5">
                    <h3 class="footer-heading mb-4">Contact Info</h3>
                    <ul class="list-unstyled">
                        <li class="address">Jl. Raya Karadenan No.7, Karadenan, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16111</li>
                        <li class="phone"><a href="tel://+6285891586352">+62 858 9158 6352</a></li>
                        <li class="email">akmalmhank21@gmail.com</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row pt-5 mt-5 text-center border-top">
            <div class="col-md-12">
                <p>
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script> 
                    All rights reserved | Pharmal
                </p>
            </div>
        </div>
    </div>
</footer>