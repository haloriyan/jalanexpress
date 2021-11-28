@extends('layouts.courier')

@section('title', "Home")

@php
    $names = explode(" ", $myData->name);
    $sumReceivers = 0;
    foreach ($thisMonthJob as $job) {
        $sumReceivers += $job->receivers->count();
    }
@endphp
    
@section('content')
<div class="bg-putih rounded bayangan-5 smallPadding">
    <div class="wrap">
        <h3>Halo, {{ $names[0] }}
            <a href="#" class="teks-hijau">
                <i class="fas fa-bell ke-kanan"></i>
            </a>
        </h3>
    </div>
</div>

<div class="bg-putih rounded bayangan-5 smallPadding mt-2">
    <div class="wrap super">
        <div class="bagi bagi-2">
            <h3 class="mb-1 mt-0">{{ $sumReceivers }}</h3>
            <div class="teks-transparan teks-kecil">pengiriman</div>
        </div>
        <div class="bagi bagi-2 rata-kanan">
            <h3 class="mb-1 mt-0">@currencyEncode($thisMonthJob->sum('total_pay'))</h3>
            <div class="teks-transparan teks-kecil">pendapatan</div>
        </div>
    </div>
</div>
@endsection