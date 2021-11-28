@extends('layouts.page')

@section('title', "Tentang")

@section('head.dependencies')
<style>
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
</style>
@endsection
    
@section('content')
<div class="content">
    <section class="smallPadding">
        <div class="wrap">
            <div class="rata-tengah">
                <div class="bagi lebar-70 desktop">
                    <h2>Bayangkan... Kiriman Anda tiba di penerima <br /> secepat Anda berkendara sendirian</h2>
                    <p>
                        <span class="teks-tebal">Jalan<span class="teks-hijau">Express</span></span>
                        mewujudkan imajinasi ini dan Anda tak perlu membayangkannya lagi.
                    </p>
                    <hr size="2" color="#ddd" width="10%" class="mt-4" />
                </div>
            </div>
            <div class="tinggi-70"></div>
            <div class="rata-tengah">
                <div class="bagi lebar-60 desktop rata-kiri">
                    <p class="teks-besar">
                        {{ env('APP_NAME') }} adalah layanan jalan-jalan keliling kota bagi barang kiriman maupun dokumen dengan tarif yang lebih hemat dan anti ribet, karena Anda tidak perlu mendaftar, login, dan mengingat password.
                    </p>
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
                <h2 class="mt-0 teks-putih">Butuh Kurir yang White Label?</h2>
                <p class="teks-putih teks-besar lh-30">
                    Memiliki kurir sendiri akan membuat usaha kita semakin terlihat terpercaya, namun tentu mempekerjakan kurir perlu biaya cukup banyak.
                    Kami ingin membantu menaikkan reputasi usaha Anda dengan mengirimkan kurir kami dengan branding usaha Anda sendiri.
                </p>
                <button class="bg-putih teks-hijau rounded-circle lebar-60 mt-3">Hubungi Sales</button>
            </div>
        </div>
    </section>

    @include('components.Footer')
</div>
@endsection