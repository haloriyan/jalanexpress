@extends('layouts.courier')

@section('title', "Profil")
    
@section('content')
<div class="bg-putih rounded bayangan-5 smallPadding">
    <div class="wrap">
        <h3>{{ $myData->name }}</h3>
    </div>
</div>
@endsection