@extends('layouts.courier')

@section('title', "Pekerjaan Saya")

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp
    
@section('content')
<h1>Pekerjaan Saya</h1>

@foreach ($jobs as $job)
    <a href="{{ route('courier.find.detail', $job->id) }}">
        <div class="bg-putih rounded bayangan-5 smallPadding">
            <div class="wrap super">
                <h4 class="m-0 mb-1">{{ $job->sender_name }} - {{ $job->sender_phone }}</h4>
                <div class="teks-kecil">{{ $job->sender_region }}</div>
    
                <div class="tinggi-20"></div>
    
                <div class="bagi bagi-3 teks-kecil teks-transparan">
                    <i class="fas fa-calendar mr-1"></i>
                    {{ Carbon::parse($job->pickup_date)->isoFormat('DD MMM') }}
                </div>
                <div class="bagi bagi-3 teks-kecil teks-transparan">
                    <i class="fas fa-users mr-1"></i>
                    {{ $job->receivers->count() }} alamat
                </div>
                <div class="bagi bagi-3 teks-kecil teks-transparan">
                    <i class="fas fa-box mr-1"></i>
                    {{ $job->receivers->sum('weight') }} kg
                </div>
            </div>
        </div>
    </a>
@endforeach

@endsection