@extends('layouts.courier')

@section('title', "Edit Profil")

@section('head.dependencies')
<style>
    body { background-color: #fff; }
    header {
        left: 0px;right: 0px;top: 0px;
        line-height: 60px;
        z-index: 2;
    }
    header h1 {
        font-size: 20px;
        margin: 0;
        margin-left: 5%;
    }
    .content {
        top: 60px;left: 0px;right: 0px;
    }
</style>
@endsection
    
@section('header')
<header class="bg-hijau">
    <h1 class="teks-putih ke-kiri">Edit Profil</h1>
</header>
@endsection

@section('content')
<form action="{{ route('courier.profile.edit') }}" method="POST" class="wrap mt-4" enctype="multipart/form-data">
    {{ csrf_field() }}
    @if ($message != "")
        <div class="bg-hijau-transparan rounded p-2 mb-3">
            {{ $message }}
        </div>
    @endif

    <div class="mt-2">Nama :</div>
    <input type="text" class="box" name="name" required value="{{ $myData->name }}">
    <div class="mt-2">Ubah Password :</div>
    <input type="password" class="box" name="password">
    <div class="teks-kecil teks-transparan mt-1">kosongkan jika tidak ingin mengganti password</div>

    <div class="mt-2">Ganti Foto :</div>
    <input type="file" class="box teks-kecil" name="photo">
    <div class="teks-kecil teks-transparan mt-1">kosongkan jika tidak ingin mengganti foto</div>

    <button class="hijau lebar-100 mt-3 tinggi-50 teks-kecil p-0">Simpan Perubahan</button>
</form>
@endsection