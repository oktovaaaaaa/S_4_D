<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="index.html" class="logo d-flex align-items-center me-auto">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="assets/img/logo.png" alt=""> -->
            <h1 class="sitename">Del Cafe</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li class="{{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li class="{{ request()->is('menu') ? 'active' : '' }}">
                    <a href="{{ route('userr.menu') }}">Menu</a>
                </li>
                <li class="{{ request()->is('jadwal') ? 'active' : '' }}">
                    <a href="{{ route('userr.jadwal') }}">Jadwal</a>
                </li>
                <li class="{{ request()->is('tentang') ? 'active' : '' }}">
                    <a href="{{route('userr.tentang')}}">Tentang</a>
                </li>
                <li class="{{ request()->is('galeri') ? 'active' : '' }}">
                    <a href="{{route('userr.galeri')}}">Galeri</a>
                </li>
                <li class="{{ request()->is('galeri') ? 'active' : '' }}">
                    <a href="{{ route('testimoni.index') }}">Testimoni</a>
                </li>
                <li class="{{ request()->is('pengumuman') ? 'active' : '' }}">
                    <a href="{{ route('userr.pengumuman') }}">Pengumuman</a>
                </li>
                <li class="{{ request()->is('keranjang') ? 'active' : '' }}">
                    <a href="{{ route('userr.keranjang') }}">Keranjang</a>
                </li><li class="{{ request()->is('riwayat') ? 'active' : '' }}">
                    <a href="{{ route('userr.riwayatPesanan') }}">Riwayat</a>
                </li>
                <li class="{{ request()->is('kontak') ? 'active' : '' }}">
                    <a href="{{ route('kontakuserr') }}">Kontak</a>
                </li>
                {{-- <li class="dropdown">
                    <a href="#" class="{{ request()->is('dropdown*') ? 'active' : '' }}">
                        <span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i>
                    </a>
                    <ul>
                        <li><a href="#">Dropdown 1</a></li>
                        <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="#">Deep Dropdown 1</a></li>
                                <li><a href="#">Deep Dropdown 2</a></li>
                                <li><a href="#">Deep Dropdown 3</a></li>
                                <li><a href="#">Deep Dropdown 4</a></li>
                                <li><a href="#">Deep Dropdown 5</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Dropdown 2</a></li>
                        <li><a href="#">Dropdown 3</a></li>
                        <li><a href="#">Dropdown 4</a></li>
                 --}}    </ul>
                </li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

       <!-- Authentication Links -->
        @auth
            @if(auth()->user()->role == 'user')
                <a class="btn-getstarted" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a class="btn-getstarted" href="{{route('menus.tampilan')}}">Dashboard</a>
            @endif
        @else
            <a class="btn-getstarted" href="{{ route('login') }}">Login</a>
        @endauth

    </div>
</header>
