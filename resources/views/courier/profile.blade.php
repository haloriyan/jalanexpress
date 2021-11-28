@extends('layouts.courier')

@section('title', "Profil")

@section('head.dependencies')
<style>
    .menus a { color: #444; }
    .menus li {
        list-style: none;
        border-bottom: 1px solid #aaa;
        padding: 20px 0px;
        font-size: 14px;
    }
    .photo {
        width: 120px;
        height: 120px;
        border-radius: 900px;
        margin-top: -80px;
        margin-bottom: 20px;
    }
</style>
@endsection

@php
    $photo = $myData->photo == null ? asset("images/user-default.jpg") : asset('storage/courier_photo/'.$myData->photo);
@endphp
    
@section('content')
<div class="bg-putih rounded bayangan-5 mt-5 smallPadding rata-tengah">
    <div class="wrap">
        <div class="bagi photo" bg-image="{{ $photo }}"></div>
        <h3>{{ $myData->name }}</h3>
        <a href="{{ route('courier.profile.edit') }}" class="teks-hijau teks-tebal teks-kecil">
            Edit Profil
        </a>
    </div>
</div>

<div class="bg-putih rounded bayangan-5 smallPadding mt-3 menus">
    <div class="wrap">
        <a href="{{ route('courier.history') }}">
            <li>Riwayat Pengiriman</li>
        </a>
        <a href="#">
            <li>Logout</li>
        </a>
    </div>
</div>
@endsection