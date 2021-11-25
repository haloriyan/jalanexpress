@extends('layouts.page')

@section('title', "Booking Diterima")
    
@section('content')
<div class="content">
    <div class="rata-tengah wrap">
        <div class="bagi lebar-60 desktop rata-kiri">
            <p>Kami telah menerima pemesanan booking order Anda. Salin kode ini untuk mengecek status pengiriman Anda melalui halaman <a href="#">Lacak Pengiriman</a></p>

            <div class="bordered p-2 rounded teks-besar teks-tebal teks-hijau pointer mt-4" onclick="salin('haloriyan')">
                #uyw8eg9u3b9f
                <i class="ke-kanan fas fa-copy pointer"></i>
            </div>
            <div id="copyAlert" class="bg-hijau-transparan p-1 rounded teks-kecil mt-2 d-none">
                Kode berhasil disalin
            </div>

            <a href="{{ route('user.pay', ['code' => "1234"]) }}">
                <button type="submit" class="ke-kanan hijau mt-4">Lanjut ke Pembayaran</button>
            </a>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    const salin = teks => {
        copyText(teks, () => {
            select("#copyAlert").classList.remove('d-none');
            setTimeout(() => {
                select("#copyAlert").classList.add('d-none');
            }, 1500);
        });
    }
</script>
@endsection