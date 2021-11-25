<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fa/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    
<header>
    <div class="pointer" onclick="toggleMenu()" id="menuBtn"><i class="fas fa-bars"></i></div>
    <h1>@yield('title')</h1>
    <div class="action">
        @yield('header.action')
    </div>
</header>

<nav class="main hide">
    <a href="{{ route('admin.dashboard') }}">
        <li class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-home"></i></div>
            <div class="text">Dashboard</div>
        </li>
    </a>
    <a href="{{ route('admin.schedule') }}">
        <li class="{{ Route::currentRouteName() == 'admin.schedule' ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-clock"></i></div>
            <div class="text">Schedule</div>
        </li>
    </a>
    <a href="{{ route('admin.courier') }}">
        <li class="{{ Route::currentRouteName() == 'admin.courier' ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-motorcycle"></i></div>
            <div class="text">Courier</div>
        </li>
    </a>
</nav>

<div class="content">
    @yield('content')
    <div class="tinggi-80"></div>
</div>

<script src="{{ asset('js/base.js') }}"></script>
<script>
    const toggleMenu = () => {
        select("nav.main").classList.toggle('hide');
        select(".content").classList.toggle('menuShowed');
    }
</script>
@yield('javascript')

</body>
</html>