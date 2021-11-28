@extends('layouts.page')

@section('title', "Booking Diterima")
    
@section('content')
<div class="content">
    <div class="rata-tengah wrap">
        <div class="bagi lebar-60 desktop rata-kiri">
            <p>Kami telah menerima pemesanan booking order Anda. Salin kode ini untuk mengecek status pengiriman Anda melalui halaman <a href="{{ route('user.check', ['code' => $request->code]) }}">Lacak Pengiriman</a></p>

            <div class="bordered p-2 rounded teks-besar teks-tebal teks-hijau pointer mt-4" onclick="salin('{{ $request->code }}')">
                {{ $request->code }}
                <i class="ke-kanan fas fa-copy pointer"></i>
            </div>
            <div id="copyAlert" class="bg-hijau-transparan p-2 rounded mt-2 d-none">
                Kode berhasil disalin
            </div>

            <p>Mohon untuk menyiapkan uang pas sebesar <span class="teks-tebal">@currencyEncode($shipment->receivers->sum('ongkir'))</span> saat pickup barang</p>
        </div>
    </div>

    <div class="tinggi-60"></div>
    @include('components.Footer')
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