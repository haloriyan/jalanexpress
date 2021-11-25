<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fa/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/courier.css') }}">
    @yield('head.dependencies')
</head>
<body>

@yield('header')
    
<nav class="main-menu">
    <a href="{{ route('courier.home') }}">
        <li class="bagi bagi-4 {{ Route::currentRouteName() == 'courier.home' ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-home"></i></div>
            <div class="text">Home</div>
        </li>
    </a>
    <a href="{{ route('courier.find') }}">
        <li class="bagi bagi-4 {{ Route::currentRouteName() == 'courier.find' ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-search"></i></div>
            <div class="text">Cari</div>
        </li>
    </a>
    <a href="{{ route('courier.job') }}">
        <li class="bagi bagi-4 {{ Route::currentRouteName() == 'courier.job' ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-box"></i></div>
            <div class="text">Pekerjaan</div>
        </li>
    </a>
    <a href="{{ route('courier.profile') }}">
        <li class="bagi bagi-4 {{ Route::currentRouteName() == 'courier.profile' ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-user"></i></div>
            <div class="text">Profil</div>
        </li>
    </a>
</nav>

<div class="content">
    @yield('content')
    <div class="tinggi-90"></div>
</div>

<script src="{{ asset('js/base.js') }}"></script>
@yield('javascript')

</body>
</html>