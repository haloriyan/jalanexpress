@extends('layouts.page')

@section('title', "Syarat & Ketentuan")

@section('head.dependencies')
<style>
    .content .khusus li {
        line-height: 40px;
        font-size: 18px;
    }
    .wrap.khusus { margin: 0; }
    @media (max-width: 480px) {
        .content .khusus li { line-height: 30px; }
        .wrap.khusus { margin: 5%; }
    }
</style>
@endsection
    
@section('content')
<div class="content rata-tengah">
    <div class="wrap khusus">
        <div class="bagi desktop lebar-70 rata-kiri">
            <h2>Syarat & Ketentuan Layanan Pengiriman JalanExpress</h2>
            <p>
                Pada halaman ini, JalanExpress (yang selanjutnya akan disebut sebagai "Kami") mengatur segala bentuk penggunaan layanan pengiriman yang kami berikan.
            </p>
    
            <h3>1. Ketentuan Umum</h3>
            <ol type="a">
                <li>Dalam proses logistik, pihak-pihak yang terlibat adalah JalanExpress sebagai penyedia layanan, pengirim barang, penerima barang, dan pengantar barang atau kurir</li>
                <li>Konten yang ada di dalam halaman ini dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu</li>
                <li>Pembatalan hanya dapat dilakukan maksimal 3 jam sebelum waktu pengambilan</li>
            </ol>
    
            <h3>2. Hak dan Kewajiban Para Pihak</h3>
            <ol>
                <li>
                    <p>Kami dan Pengantar memiliki hak dan kewajiban untuk :</p>
                    <ol type="a">
                        <li>Menyediakan layanan pengiriman yang aman dan cepat, serta kemudahan sebagai penunjang layanan pengiriman berupa situs web</li>
                        <li>Membatalkan atau meminta untuk mengubah muatan pengiriman apabila barang tidak sesuai dengan informasi yang diberikan oleh Pengirim kepada Kami</li>
                        <li>Menghubungi pihak Pengirim dan Penerima sewaktu-waktu mulai Pengirim memasukkan data booking di situs ini hingga barang tiba pada Penerima, dan hanya untuk keperluan pengiriman saja</li>
                        <li>Dapat dihubungi baik oleh Pengirim atau Penerima saat pengiriman sedang berlangsung</li>
                    </ol>
                </li>
                <li>
                    <p>Pengirim memiliki hak dan kewajiban untuk :</p>
                    <ol type="a">
                        <li>Meminta untuk mengganti latar belakang dan/atau <i>angle</i> saat difoto oleh pengantar untuk menghindari kriminal dan tindakan merugikan lainnya</li>
                        <li>Menyediakan informasi yang sebenarnya dan dapat dipertanggung-jawabkan</li>
                        <li>Mengemas barang agar siap diambil ketika Pengantar tiba</li>
                    </ol>
                </li>
                <li>
                    <p>Penerima memiliki hak dan kewajiban untuk :</p>
                    <ol type="a">
                        <li>Meminta untuk mengganti latar belakang dan/atau <i>angle</i> saat difoto oleh pengantar untuk menghindari kriminal dan tindakan merugikan lainnya</li>
                        <li>Dapat dihubungi sewaktu-waktu baik oleh Kami atau Pengantar terkait dengan pengiriman yang diminta oleh Pengirim</li>
                    </ol>
                </li>
            </ol>

            <h3>3. Barang yang Dapat Dikirim</h3>
            <p>Kami mengatur jenis barang yang dapat dikirim melalui layanan JalanExpress agar tidak mengganggu proses pengiriman nantinya</p>
            <ol type="a">
                <li>Bukan merupakan barang yang dilarang oleh Undang-Undang secara konstitusional maupun hukum daerah yang berlaku, mudah terbakar, dan barang pecah-belah</li>
                <li>Berat per alamat tidak melebihi 7 kilogram untuk setiap penerima atau 20 kilogram dalam satu kali pengiriman; dan/atau</li>
                <li>Dimensi barang per alamat tidak lebih dari 8000 cm<sup>3</sup> (20 x 20 x 20 cm)</li>
                <li>Telah dipak / dikemas rapi dan aman untuk dibawa berkendara</li>
            </ol>

            <h3>4. Kebijakan Privasi</h3>
            <p>Sebagai layanan yang berbasis teknologi, Kami sangat menghormati privasi para pengguna kami dan dapat kami pastikan akan terjaga kerahasiaannya</p>
            <ol type="a">
                <li>Pengantar akan meminta foto barang beserta penanggung jawab dari pihak Pengirim dan Penerima. Namun Pengirim dan Penerima dapat menolak untuk menampilkan wajah, sehingga hanya terlihat badan saja.</li>
                <li>Pengirim dan Penerima berhak mengganti latar belakang atau <i>angle</i> saat difoto guna menghindari kriminal atau tindakan merugikan lainnya</li>
                <li>Foto ini tidak akan kami bagikan kepada Pengirim maupun Penerima tanpa peruntukkan yang mendesak</li>
                <li>Pengantar tidak diperkenankan melihat isi dari barang yang dikirimkan. Apabila terdapat ketidak-sesuaian dengan informasi yang Pengirim berikan, kami tidak bertanggung jawab atas hal ini.</li>
            </ol>
        </div>
    </div>

    <div class="tinggi-70"></div>

    @include('components.Footer')
</div>
@endsection