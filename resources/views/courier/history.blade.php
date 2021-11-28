@extends('layouts.courier')

@section('title', "Riwayat Pengiriman")

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
    $monthNow = $month;
    $months = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
@endphp
    
@section('content')
<div class="bagi bagi-2 mt-1">
    <h2 class="mt-0">Riwayat Pengiriman</h2>
</div>
<div class="bagi bagi-2 mt-1 rata-kanan">
    <select name="filter" id="filter" class="box teks-kecil mt-0" onchange="filterMonth(this.value)">
        @foreach ($months as $key => $month)
            <option {{ $key + 1 == $monthNow ? 'selected="selected"' : '' }} value="{{ $key + 1 }}">{{ $month }}</option>
        @endforeach
    </select>
</div>

@if ($jobs->count() == 0)
    <div class="bg-putih rounded bayangan-5 smallPadding rata-tengah mt-5">
        <h3>Tidak ada riwayat</h3>
    </div>
@endif

@foreach ($jobs as $job)
    <a href="{{ route('courier.find.detail', $job->id) }}">
        <div class="bg-putih rounded bayangan-5 smallPadding mt-2">
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

@section('javascript')
<script>
    let url = new URL(document.URL);
    const filterMonth = month => {
        url.searchParams.set('month', month);
        window.location = url.toString();
    }
</script>
@endsection