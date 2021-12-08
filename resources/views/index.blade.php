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
    section h2 { font-size: 35px; }
    section h3 { font-size: 28px; }
    section p { font-size: 22px; }
    @media (max-width: 480px) {
        .content { top: 320px;width: 90%; }
        section h2 { font-size: 26px; }
        section h3 { font-size: 20px; }
        section p { font-size: 18px; }
    }
</style>
@endsection

@section('content')
<img src="{{ asset('images/illustration.png') }}" class="illustration">

<div class="content">
    <h2>{{ env('APP_DESCRIPTION') }}</h2>
    <p>
        Kirim pesanan pelangganmu ke manapun dalam Kota Surabaya dengan tarif 15 RIBU tanpa biaya tambahan apapun
    </p>

    <a href="{{ route('user.send') }}">
        <button type="submit" class="hijau lebar-50 mt-3 desktop">Kirim Barang</button>
    </a>
</div>

<div class="bottom">
    <section class="coverageArea smallPadding">
        <div class="wrap">
            <div class="bagi bagi-2 desktop rata-tengah">
                <div class="bagi lebar-80 desktop">
                    <div class="squarize rounded-more lebar-100 bagi" bg-image="{{ asset('images/courier.jpg') }}"></div>
                </div>
            </div>
            <div class="bagi bagi-2 desktop">
                <div class="tinggi-110 desktop"></div>
                <div class="tinggi-50 mobile"></div>

                <h2 class="mt-2 lh-45">Bergerak Lebih Gesit dari yang Pernah Anda Lakukan</h2>
                <p class="teks-besar lh-35">
                    Kecepatan waktu pengiriman adalah hal yang krusial dalam pelayanan. Kami mengirim pesanan Anda kepada pelanggan secepat Anda berkendara sendirian.
                </p>

                <a href="{{ route('user.about') }}" class="teks-primer teks-tebal">
                    <div class="bagi mt-2">
                        Selengkapnya
                        <hr size="2" color="#27ae60" class="mt-1" />
                    </div>
                </a>
            </div>

            <div class="tinggi-120 desktop"></div>

            <div class="bagi bagi-2 desktop rata-kanan">
                <div class="tinggi-120 desktop"></div>
                <div class="tinggi-50 mobile"></div>
                <h2 class="mt-0 lh-45">Tidak Perlu Bingung Menghitung Ongkir yang Progresif</h2>
                <p class="teks-besar lh-35">
                    Kami sendiri bingung menghitung ongkir dari kompetitor yang tidak sama seperti yang pertama ditawarkan.
                    Karena itu JalanExpress tidak melakukannya. Tarif kami flat per alamat tanpa biaya tambahan apapun
                </p>

                <a href="{{ route('user.pricing') }}" class="teks-primer teks-tebal">
                    <div class="bagi mt-2">
                        Selengkapnya
                        <hr size="2" color="#27ae60" class="mt-1" />
                    </div>
                </a>
            </div>
            <div class="bagi bagi-2 desktop rata-tengah">
                <div class="tinggi-40 mobile"></div>
                <div class="bagi lebar-80 desktop">
                    <div class="squarize rounded-more lebar-100 bagi" bg-image="{{ asset('images/calculate.jpg') }}"></div>
                </div>
            </div>
        </div>
    </section>
    <section class="howto rata-tengah">
        <div class="wrap">
            <h2>Kirim Barang dengan 3 Langkah Mudah</h2>
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

    <section class="whiteLabel bg-hijau-2 smallPadding">
        <div class="wrap super">
            <div class="bagi lebar-65 desktop">
                <h3 class="mt-1 teks-putih">Butuh Kurir yang White Label?</h3>
                <p class="teks-putih lh-35">
                    Memiliki kurir sendiri akan membuat usaha kita semakin terlihat terpercaya, namun tentu mempekerjakan kurir perlu biaya cukup banyak.
                    Kami ingin membantu menaikkan reputasi usaha Anda dengan mengirimkan kurir kami dengan branding usaha Anda sendiri.
                </p>
                <button class="bg-putih teks-hijau rounded-circle lebar-60 mt-3">Hubungi Sales</button>
            </div>
        </div>
    </section>

    @include('components/Footer')
</div>
@endsection