@extends('layouts.courier')

@section('title', "Detail Kiriman")

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp

@section('head.dependencies')
<style>
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
    .content .icon { width: 35px; }
    #grabForm {
        position: fixed;
        left: 5%;right: 5%;bottom: 80px;
    }
</style>
@endsection
    
@section('header')
<header class="bg-hijau">
    <h1 class="teks-putih ke-kiri">Detail Kiriman</h1>
</header>
@endsection

@section('content')
<div class="bg-putih border-bottom smallPadding">
    <div class="wrap super">
        <h3 class="teks-besar">{{ $job->sender_name }}
            <div class="ke-kanan">{{ $job->receivers->sum('weight') }} kg</div>
        </h3>
        <div class="teks-kecil">
            <div class="mt-3">
                <div class="bagi icon"><i class="fab fa-whatsapp"></i></div>
                <div class="bagi text">{{ $job->sender_phone }}</div>
            </div>
            <div class="mt-1">
                <div class="bagi icon"><i class="fas fa-calendar"></i></div>
                <div class="bagi text">{{ Carbon::parse($job->pickup_date)->isoFormat('DD MMMM') }} - {{ Carbon::parse($job->pickup_time)->format('H:i') }}</div>
            </div>
            <div class="mt-1">
                <div class="bagi icon"><i class="fas fa-money-bill-alt"></i></div>
                <div class="bagi text">@currencyEncode($job->total_pay)</div>
            </div>
            <div class="mt-1">
                <div class="bagi icon"><i class="fas fa-map-marker"></i></div>
                <div class="bagi text">
                    {{ $job->sender_region }} <br />
                    <div class="mt-1">{{ $job->sender_address }}</div>
                </div>
            </div>

            @if ($job->pickup_date == date('Y-m-d'))
                @if ($job->pickup_photo == null)
                    <form action="{{ route('courier.job.pickup', $job->id) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="mt-2">Upload Foto Pengambilan :</div>
                        <input type="file" class="box tinggi-40 teks-kecil" name="pickup_photo" required>
                        <button class="hijau p-0 pl-2 pr-2 tinggi-40 mt-1">Upload</button>
                    </form>
                @else
                    <div class="bg-hijau-transparan rounded p-2 mt-2">
                        Barang telah diambil, harap segera mengirimkan kepada penerima yang tertera di bawah
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

<div class="wrap mt-0">
    @foreach ($job->receivers as $receiver)
        <div class="rata-tengah mt-1 mb-1">
            <div class="bagi tinggi-50" style="width: 3px;background-color: #ddd;"></div>
        </div>
        <div class="bg-putih rounded bordered smallPadding">
            <div class="wrap">
                @if ($receiver->photo != null)
                    <div class="tinggi-200 rounded" bg-image="{{ asset('storage/foto_barang/'.$receiver->photo) }}"></div>
                @endif
                <h4 class="mb-1">{{ $receiver->receiver_region }}</h4>
                <div>{{ $receiver->receiver_address }}</div>

                <div class="mt-2 teks-kecil">
                    <div class="bagi icon"><i class="fas fa-user"></i></div>
                    <div class="bagi text">{{ $receiver->receiver_name }} - {{ $receiver->receiver_phone }}</div>
                </div>
                <div class="mt-1 teks-kecil">
                    <div class="bagi icon"><i class="fas fa-box"></i></div>
                    <div class="bagi text">{{ $receiver->weight }} kg ({{ $receiver->dimension }} cm)</div>
                </div>

                @if ($receiver->notes != null)
                    <div class="mt-1 teks-kecil">
                        <div class="bagi icon"><i class="fas fa-edit"></i></div>
                        <div class="bagi text">{{ $receiver->notes }}</div>
                    </div>
                @endif

                @if ($job->courier_id == $myData->id && $job->pickup_date == date('Y-m-d') && $job->pickup_photo != null)
                    <form action="#" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                        <div class="mt-2">Upload Bukti Pengiriman :</div>
                        <input type="file" class="box teks-kecil tinggi-40" name="bukti_kirim">
                        <button class="teks-kecil hijau p-0 tinggi-40 mt-1 pl-2 pr-2">Upload</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
</div>

@if ($job->courier_id == null)
    <div class="tinggi-50"></div>
    <form action="{{ route('courier.find.grab', $job->id) }}" method="POST" id="grabForm">
        {{ csrf_field() }}
        <button class="hijau rounded-circle rata-tengah lebar-100">Ambil Kiriman</button>
    </form>
@endif

@endsection