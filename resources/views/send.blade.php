@extends('layouts.page')

@section('title', "Kirim Barang")

@section('head.dependencies')
<link rel="stylesheet" href="{{ asset('js/flatpickr/dist/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/flatpickr/dist/themes/material_green.css') }}">
<style>
    .box,input.box {
        height: 40px;
        padding: 0px 15px;
        font-size: 15px;
    }
    .box[readonly] { background-color: #fff; }
    button[type=submit] {
        position: fixed;
        bottom: 40px;right: 5%;
        width: 80px;
        height: 80px;
        padding: 0px;
        border-radius: 900px;
        display: none;
    }
    @media (max-width: 480px) {
        button[type=submit] {
            width: 100%;
            height: 55px;
        }
    }
    .times {
        background-color: #ecf0f1;
        border: 1px solid #ddd;
        padding: 8px 20px;
        margin-top: 10px;
        cursor: pointer;
    }
    .times.active {
        background-color: #2ecc71;
        color: #fff;
        border: none;
    }
    .content { left: 0px;right: 0px; }
</style>
@endsection

@php
    $showedSenderRegion = [];
@endphp
    
@section('content')
<form action="{{ route('user.sending') }}" method="POST" class="content rata-tengah" id="sendForm" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" id="schedules" value="{{ $schedules }}">
    <h2 class="m-0 rata-tengah">Kirim Barang</h2>

    <div class="bagi bagi-2 desktop rata-kiri senderArea">
        <div class="wrap">
            <div class="bg-putih rounded bayangan-5 mb-3 smallPadding">
                <h3 class="border-bottom m-0 p-2 pl-3 pr-3">Informasi Pengirim</h3>
                <div class="wrap">
                    <div class="mt-2">Alamat Pengambilan :</div>
                    <select name="sender_region" class="box" required>
                        <option value="">-- PILIH AREA --</option>
                        @foreach ($schedules as $schedule)
                            @if (!in_array($schedule->region, $showedSenderRegion))
                                <option>{{ $schedule->region }}</option>
                            @endif
                            @php
                                array_push($showedSenderRegion, $schedule->region)
                            @endphp
                        @endforeach
                    </select>
                    <textarea name="sender_address" class="box" placeholder="Masukkan alamat lengkap..."></textarea>
                    <div class="mt-2">Waktu Pengambilan :</div>
                    <input type="text" class="box" id="pickup_date" name="pickup_date" required>
                    <div class="mb-2" id="timesArea"></div>
                    <input type="hidden" name="pickup_time" id="pickup_time" required>
                    <div class="bagi bagi-2 desktop">
                        <div class="mt-2">Nama Pengirim :</div>
                        <input type="text" class="box" name="sender_name" required>
                    </div>
                    <div class="bagi bagi-2 desktop">
                        <div class="mt-2">No. Whatsapp Pengirim :</div>
                        <input type="text" class="box" name="sender_phone" required>
                    </div>

                    <button type="button" class="hijau teks-kecil tinggi-40 mt-2" onclick="lanjut()">
                        Selanjutnya <i class="fas fa-angle-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="bagi bagi-2 desktop rata-kiri receiverArea" style="display: none !important;">
        <div class="wrap">
            <div id="renderReceivers"></div>
            <button type="button" class="teks-kecil teks-hijau tinggi-40 mt-2" onclick="balik()">
                <i class="fas fa-angle-left mr-1"></i> ubah informasi pengirim
            </button>
            <button type="button" class="hijau teks-kecil ke-kanan tinggi-40 mt-2" onclick="renderReceiver()">
                <i class="fas fa-plus mr-1"></i> Tambah Penerima
            </button>
        </div>
    </div>

    <button class="hijau" type="submit" id="sendBtn">Kirim</button>

    <div class="tinggi-120"></div>

    @include('components/Footer')
</form>

@endsection

@section('javascript')
<script src="{{ asset('js/flatpickr/dist/flatpickr.min.js') }}"></script>
<script>
    let iReceivers = 0;
    let schedules = JSON.parse(select("#schedules").value);
    let choosenTime = "";

    flatpickr("#pickup_date", {
        minDate: "{{ date('Y-m-d') }}",
        dateFormat: 'Y-m-d'
    });

    const renderReceiver = (isInit = null) => {
        iReceivers += 1;
        let removeBtn = '';
        if (isInit == null) {
            removeBtn = `<i class="fas fa-trash ke-kanan pointer teks-merah" onclick="removeReceiver(this)"></i>`;
        }
        let htmlContent = `<h3 class="border-bottom m-0 p-2 pl-3 pr-3">
                Informasi Penerima ${isInit == null ? 'Lainnya' : ''}
                ${removeBtn}
            </h3>
            <div class="wrap">
            <div class="mt-2">Alamat Pengiriman :</div>
                <select name="receiver_region[]" id="receiver_region" class="box" required>
                    <option value="">-- PILIH AREA --</option>
                </select>
                <textarea name="receiver_address[]" id="receiver_address" class="box" placeholder="Masukkan alamat lengkap..."></textarea>
                <div class="bagi bagi-2 desktop">
                    <div class="mt-2">Nama Penerima :</div>
                    <input type="text" class="box" id="receiver_name" name="receiver_name[]" required>
                </div>
                <div class="bagi bagi-2 desktop">
                    <div class="mt-2">No. Whatsapp Penerima :</div>
                    <input type="text" class="box" name="receiver_phone[]" required>
                </div>

                <div class="bagi bagi-3">
                    <div class="mt-2"> Berat (kg) :</div>
                    <input type="number" min="1" max="6" class="box" name="weight[]" required>
                </div>
                <div class="bagi bagi-3">
                    <div class="mt-2"> Dimensi (cm) :</div>
                    <input type="text" class="box" name="dimension[]" required placeholder="p x l x t">
                </div>
                <div class="bagi bagi-3">
                    <div class="mt-2">Foto Barang :</div>
                    <input type="file" class="box" name="photos[]">
                </div>

                <div class="mt-2">Catatan :</div>
                <textarea name="notes[]" class="box"></textarea>
            </div>`;
        
        createElement({
            el: 'div',
            attributes: [
                ['class', 'bg-putih rounded bayangan-5 smallPadding mb-2'],
                ['id', `receiver_${iReceivers}`]
            ],
            html: htmlContent,
            createTo: '#renderReceivers'
        });

        let renderedRegions = [];
        schedules.forEach(schedule => {
            if (!inArray(schedule.region, renderedRegions)) {
                createElement({
                    el: 'option',
                    html: schedule.region,
                    createTo: `#receiver_${iReceivers} select#receiver_region`
                })
            }
            renderedRegions.push(schedule.region);
        });

        if (isInit == null) {
            scrollKe(`#receiver_${iReceivers}`);
        }
    }

    const chooseTime = time => {
        selectAll(".times").forEach(t => t.classList.remove('active'));
        choosenTime = time.innerText;
        time.classList.add('active');
        select("#pickup_time").value = choosenTime;
    }

    const init = () => {
        let renderedTimes = [];
        schedules.forEach(schedule => {
            let time = displayTime(schedule.time);
            if (!inArray(schedule.time, renderedTimes)) {
                createElement({
                    el: 'div',
                    attributes: [
                        ['class', 'times bagi rounded-circle mr-1'],
                        ['onclick', 'chooseTime(this)']
                    ],
                    html: time,
                    createTo: '#timesArea'
                })
            }
            renderedTimes.push(schedule.time);
        })
        
        renderReceiver(1);
    }
    init();

    const removeReceiver = btn => {
        let area = btn.parentNode.parentNode;
        iReceivers -= 1;
        area.remove();
    }

    const lanjut = () => {
        select(".senderArea").style.display = "none";
        select(".receiverArea").style.display = "inline-block";
        select("#sendBtn").style.display = "block";
    }
    const balik = () => {
        select(".senderArea").style.display = "inlin-block";
        select(".receiverArea").style.display = "none";
        select("#sendBtn").style.display = "none";
    }
</script>
@endsection