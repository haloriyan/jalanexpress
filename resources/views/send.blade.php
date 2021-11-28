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
    .totalArea {
        position: fixed;
        bottom: 50px;right: 15%;
        z-index: 3;
        background-color: #fff;
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
    <input type="hidden" name="ongkirs" id="calculatedOngkir">
    <h2 class="m-0 rata-tengah">Kirim Barang</h2>

    <div class="bagi bagi-2 desktop rata-kiri senderArea">
        <div class="wrap">
            <div class="bg-putih rounded bayangan-5 mb-3 smallPadding">
                <h3 class="border-bottom m-0 p-2 pl-3 pr-3">Informasi Pengirim</h3>
                <div class="wrap">
                    <div class="mt-2">Alamat Pengambilan :</div>
                    <select name="sender_region" id="sender_region" class="box" required>
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
                    <textarea name="sender_address" id="sender_address" class="box" placeholder="Masukkan alamat lengkap..."></textarea>
                    <div class="mt-2">Tanggal Pengambilan :</div>
                    <input type="text" class="box" id="pickup_date" name="pickup_date" required>
                    <div class="mb-2" id="timesArea"></div>
                    <input type="hidden" name="pickup_time" id="pickup_time" required>
                    <div class="bagi bagi-2 desktop">
                        <div class="mt-2">Nama Pengirim :</div>
                        <input type="text" class="box" id="sender_name" name="sender_name" required>
                    </div>
                    <div class="bagi bagi-2 desktop">
                        <div class="mt-2">No. Whatsapp Pengirim :</div>
                        <input type="text" class="box" id="sender_phone" name="sender_phone" required>
                    </div>

                    <div id="errorArea"></div>

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

            <div class="mt-2 teks-kecil">dengan menggunakan layanan pengiriman JalanExpress, Anda menyetujui <a href="{{ route('user.term') }}" target="_blank">Syarat dan Ketentuan</a> yang berlaku</div>
        </div>
    </div>

    <button class="hijau" type="submit" id="sendBtn">Kirim</button>

    <div class="totalArea bayangan-5 rounded p-2 d-none">
        Total : <span class="teks-tebal" id="total">Rp 0</span>
    </div>

    <div class="tinggi-120"></div>

    @include('components/Footer')
</form>

@endsection

@section('javascript')
<script src="{{ asset('js/flatpickr/dist/flatpickr.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script>
    let iReceivers = 0;
    let calculatedOngkir = [];
    let schedules = JSON.parse(select("#schedules").value);
    let choosenTime = "";
    let receiverTemp = {};
    let receivers = [];
    let minDate = moment("{{ date('Y-m-d') }}").add(1, 'day').format('YYYY-MM-DD');

    flatpickr("#pickup_date", {
        minDate: minDate,
        dateFormat: 'Y-m-d'
    });

    const calculateOngkir = (val, i) => {
        i -= 1;
        schedules.forEach(schedule => {
            if (schedule.region == val && schedule.time == `${choosenTime}:00`) {
                calculatedOngkir[i] = schedule.price;
            }
        });

        let sumOngkir = calculatedOngkir.reduce((a, b) => a + b);
        select(".totalArea").classList.remove('d-none');
        select(".totalArea #total").innerText = toIdr(sumOngkir);
        select("input#calculatedOngkir").value = calculatedOngkir.toString();
    }

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
                <select name="receiver_region[]" id="receiver_region" class="box" required onchange="calculateOngkir(this.value, ${iReceivers})">
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
        let hasError = false;
        let inputsName = {
            sender_region: 'Area Pengambilan',
            sender_address: 'Alamat Pengambilan',
            sender_name: 'Nama Pengirim',
            sender_phone: 'No. Whatsapp Pengirim',
            pickup_date: 'Tanggal Pengambilan'
        };
        selectAll(".senderArea input,.senderArea textarea,.senderArea select").forEach(item => {
            let type = item.getAttribute('type');
            if (type !== undefined  && type != 'hidden' && item.value == "") {
                hasError = true;
                let name = item.getAttribute('name');
                printError(`${inputsName[name]} belum diisi <i class="fas fa-times pointer ke-kanan" onclick="removeError(this)"></i>`);
            }
        });
        if (choosenTime == "") {
            hasError = true;
            printError(`Waktu Pengambilan belum dipilih <i class="fas fa-times pointer ke-kanan" onclick="removeError(this)"></i>`)
        }
        if (!hasError) {
            select(".senderArea").style.display = "none";
            select(".receiverArea").style.display = "inline-block";
            select("#sendBtn").style.display = "block";
        }
    }
    const removeError = btn => {
        let area = btn.parentNode;
        area.remove();
    }
    const printError = msg => {
        createElement({
            el: 'div',
            attributes: [['class', 'bg-merah-transparan rounded p-2 mt-2']],
            html: msg,
            createTo: '#errorArea'
        });
    }
    const balik = () => {
        select(".senderArea").style.display = "inlin-block";
        select(".receiverArea").style.display = "none";
        select("#sendBtn").style.display = "none";
    }
</script>
@endsection