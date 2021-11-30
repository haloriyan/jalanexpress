@extends('layouts.courier')

@section('title', "Home")

@php
    $names = explode(" ", $myData->name);
    $sumReceivers = 0;
    $totalRevenue = $thisMonthJob->sum('total_pay');
    foreach ($thisMonthJob as $job) {
        $sumReceivers += $job->receivers->count();
    }
    $setoran = 0;
    if ($totalRevenue > 0) {
        $setoran = 2000 * $sumReceivers;
    }
    $photo = $myData->photo == null ? asset("images/user-default.jpg") : asset('storage/courier_photo/'.$myData->photo);
@endphp
    
@section('content')
<div class="bg-putih rounded bayangan-5 smallPadding">
    <div class="wrap">
        <div class="bagi lebar-80">
            <h3 class="mt-1 mb-0">Halo, {{ $names[0] }}</h3>
            <div class="mt-1 teks-kecil teks-transparan">
                Setoran : @currencyEncode($setoran)
            </div>
        </div>
        <div class="bagi lebar-20">
            <div class="photo lebar-100 squarize rounded-circle" bg-image="{{ $photo }}"></div>
        </div>
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