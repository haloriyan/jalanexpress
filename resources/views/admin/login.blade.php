@extends('layouts.auth')

@section('title', "Login Admin")
    
@section('content')
<div class="rata-tengah">
    <img src="{{ asset('images/logo.png') }}" class="tinggi-100">
</div>

<form action="#" method="POST" class="mt-4">
    @if ($errors->count() != 0)
        @foreach ($errors->all() as $err)
            <div class="bg-merah-transparan rounded p-2 mb-2">
                {{ $err }}
            </div>
        @endforeach
    @endif
    {{ csrf_field() }}
    <div class="mt-2">Email :</div>
    <input type="email" class="box" name="email" required>
    <div class="mt-2">Password :</div>
    <input type="password" class="box" name="password" required>

    <button class="lebar-100 mt-3 hijau">Login</button>
</form>
@endsection