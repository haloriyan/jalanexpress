@extends('layouts.courier')

@section('title', "Cari Kiriman")

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
    $showedSenderRegion = [];
@endphp

@section('head.dependencies')
<style>
    .content {
        top: 100px;
    }
</style>
@endsection

@section('header')
<header class="bg-putih bayangan-5 rounded">
    <select name="region" id="region" class="box m-0 teks-kecil rata-tengah border-none" onchange="chooseRegion(this.value)">
        <option value="">SEMUA AREA</option>
        @foreach ($schedules as $schedule)
            @if (!in_array($schedule->region, $showedSenderRegion))
                <option {{ $schedule->region == $request->region ? 'selected="selected"' : '' }}>{{ $schedule->region }}</option>
            @endif
            @php
                array_push($showedSenderRegion, $schedule->region)
            @endphp
        @endforeach
    </select>
</header>
@endsection
    
@section('content')
@if ($jobs->count() == 0)
    <h2 class="rata-tengah">Tidak ada pengiriman</h2>
@endif

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

@section('javascript')
<script>
    const chooseRegion = region => {
        let url = new URL(document.URL);
        url.searchParams.set('region', region);
        window.location = url.toString();
    }
</script>
@endsection