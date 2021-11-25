@extends('layouts.page')

@section('title', "Home")

@section('head.dependencies')
<style>
    .content {
        left: 5%;
        width: 40%;
    }
    section.howto .icon {
        width: 150px;
        line-height: 150px;
        display: inline-block;
        border: 1px solid #3f3d56;
        color: #3f3d56;
        font-size: 28px;
    }
    section.howto .icon:hover { 
        background-color: #3f3d56;
        color: #fff;
    }
    @media (max-width: 480px) {
        .content { top: 320px;width: 90%; }
    }
</style>
@endsection

@section('content')
<img src="{{ asset('images/illustration.png') }}" class="illustration">

<div class="content">
    <h2>{{ env('APP_DESCRIPTION') }}</h2>
    <p>
        Kirim pesanan pelangganmu ke manapun dalam Kota Surabaya dengan tarif 12 RIBU tanpa biaya tambahan apapun
    </p>

    <button type="submit" class="hijau lebar-50 mt-3">Kirim Barang</button>
</div>

<div class="bottom">
    <section class="howto rata-tengah">
        <h2>Kirim Barang dengan 3 Langkah Mudah</h2>
        <div class="wrap">
            <div class="bagi bagi-3 desktop rata-tengah mt-3">
                <div class="wrap">
                    <div class="icon rounded-circle">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3 class="mt-4">Isi Data</h3>
                    <p class="lh-30">Lengkapi informasi pengirim dan penerima beserta detail barang yang akan dikirim</p>
                </div>
            </div>
            <div class="bagi bagi-3 desktop rata-tengah mt-3">
                <div class="wrap">
                    <div class="icon rounded-circle">
                        <i class="fas fa-box"></i>
                    </div>
                    <h3 class="mt-4">Packaging</h3>
                    <p class="lh-30">Kemas paket Anda untuk setiap penerima agar siap diambil pada tanggal yang Anda inginkan</p>
                </div>
            </div>
            <div class="bagi bagi-3 desktop rata-tengah mt-3">
                <div class="wrap">
                    <div class="icon rounded-circle">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <h3 class="mt-4">Antar!</h3>
                    <p class="lh-30">Kurir akan datang ke lokasi Anda sesuai tanggal dan waktu yang Anda berikan</p>
                </div>
            </div>
        </div>
    </section>

    @include('components/Footer')
</div>
@endsection