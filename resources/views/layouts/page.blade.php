<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fa/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    @yield('head.dependencies')
</head>
<body>
    
<header>
    <a href="{{ route('user.index') }}">
        <img src="{{ asset('images/icon.png') }}">
        <h1>Jalan<span>Express</span></h1>
    </a>
    <div onclick="toggleMenu()" id="menuBtn"><i class="fas fa-bars"></i></div>
    <nav>
        <div class="mobile">
            <a href="#">
                <li>Tentang</li>
            </a>
            <a href="#">
                <li>FAQ</li>
            </a>
            <a href="#">
                <li>Hubungi Kami</li>
            </a>
        </div>
        <a href="{{ route('user.check') }}">
            <li>Lacak Pengiriman</li>
        </a>
        <a href="{{ route('user.send') }}">
            <li><button class="hijau">Kirim Barang</button></li>
        </a>
        {{-- <a href="#">
            <li>Halo, Riyan <i class="fas fa-angle-down ml-1"></i>
                <ul>
                    <a href="#">
                        <li>Profil</li>
                    </a>
                    <a href="#">
                        <li>Kiriman Saya</li>
                    </a>
                    <a href="#">
                        <li>Logout</li>
                    </a>
                </ul>
            </li>
        </a> --}}
    </nav>
</header>

@yield('content')

<script src="{{ asset('js/base.js') }}"></script>
<script>
    const toggleMenu = () => {
        select("header nav").classList.toggle('active');
    }

    window.addEventListener('scroll', e => {
        let pos = this.scrollY;
        if (pos > 70) {
            select("header").classList.add('stick');
        } else {
            select("header").classList.remove('stick');
        }
    })
</script>
@yield('javascript')

</body>
</html>