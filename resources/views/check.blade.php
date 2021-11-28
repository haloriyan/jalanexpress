@extends('layouts.page')

@section('title', "Lacak Pengiriman")

@section('head.dependencies')
<style>
    #result .icon {
        display: inline-block;
        margin: -2px;
        width: 45px;
    }
</style>
@endsection
    
@section('content')
<div class="content">
    <div class="rata-tengah wrap">
        <div class="bagi lebar-60 desktop rata-kiri bayangan-5 rounded smallPadding" id="formArea">
            <div class="wrap">
                <h2 class="mt-0">Lacak Pengiriman</h2>
                <form action="#" id="formLacak">
                    <div class="mt-2">Masukkan Nomor Tracking :</div>
                    <input type="text" class="box" name="shipping_code" id="shipping_code" value="{{ $request->code }}">
                    <button class="lebar-100 mt-3 hijau">Lacak</button>
                </form>
            </div>
        </div>
        <div class="rata-kiri mt-5 d-none" id="result">
            <div class="bagi bagi-2 desktop">
                <div class="wrap">
                    <div class="bg-putih rounded bayangan-5 smallPadding">
                        <div class="wrap">
                            <h3>Informasi Pengiriman
                                #<span id="shipping_code"></span>
                            </h3>
                            <div>
                                <span id="sender_name"></span> - <span id="sender_phone"></span>
                            </div>
                            <div class="teks-kecil teks-transparan">
                                <div class="mt-1 pt-2">
                                    <div class="icon"><i class="fas fa-map-marker"></i></div>
                                    <div class="bagi lebar-85">
                                        <div id="sender_region"></div>
                                        <div id="sender_address"></div>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <div class="icon"><i class="fas fa-calendar"></i></div>
                                    <div class="bagi lebar-85">
                                        <span id="pickup_date"></span> - <span id="pickup_time"></span>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <div class="icon"><i class="fas fa-motorcycle"></i></div>
                                    <div class="bagi lebar-85">
                                        <span id="courier_name">Belum ada kurir</span> - <span id="courier_phone"></span>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <div class="icon"><i class="fas fa-box"></i></div>
                                    <div class="bagi lebar-85">
                                        <span id="total_weight"></span> kg
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bagi bagi-2 desktop">
                <div class="wrap">
                    <div id="receiverArea"></div>
                </div>
            </div>
        </div>
    </div>
    @include('components/Footer')
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
<script>
    select("#formLacak").onsubmit = function (e) {
        let code = select("#shipping_code").value;
        let req  = post("{{ route('api.track') }}", {
            code: code,
        })
        .then(res => {
            if (res.message == "OK") {
                let data = res.data;
                select("#result").classList.remove('d-none');
                scrollKe("#result");
                select("#result #shipping_code").innerText = data.shipping_code;
                select("#result #sender_name").innerText = data.sender_name;
                select("#result #sender_phone").innerText = data.sender_phone;
                select("#result #sender_region").innerText = data.sender_region;
                select("#result #sender_address").innerText = data.sender_address;
                select("#result #pickup_date").innerText = moment(data.pickup_date).format('D MMMM');
                select("#result #pickup_time").innerText = displayTime(data.pickup_time);

                if (data.courier_id != null) {
                    select("#result #courier_name").innerText = data.courier.name;
                    select("#result #courier_phone").innerHTML = `<a href="https://wa.me/${data.courier.phone}" target="_blank">${data.courier.phone}</a>`;
                }
                select("#result #total_weight").innerText = data.total_weight;

                data.receivers.forEach((receiver, i) => {
                    createElement({
                        el: 'div',
                        attributes: [
                            ['class', 'bg-putih bayangan-5 rounded smallPadding mt-3'],
                            ['id', `receiver_${i}`]
                        ],
                        html: `<div class="wrap">
                            <h3>Penerima ${i + 1}</h3>
                            <div>
                                <span id="receiver_name"></span> - <span id="receiver_phone"></span>
                            </div>
                            <div class="teks-kecil teks-transparan">
                                <div class="mt-1 pt-2">
                                    <div class="icon"><i class="fas fa-map-marker"></i></div>
                                    <div class="bagi lebar-85">
                                        <div id="receiver_region"></div>
                                        <div id="receiver_address"></div>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <div class="icon"><i class="fas fa-box"></i></div>
                                    <div class="bagi lebar-85">
                                        <span id="weight"></span> kg (<span id="dimension"></span> cm)
                                    </div>
                                </div>
                                <div class="mt-1 notesArea">
                                    <div class="icon"><i class="fas fa-edit"></i></div>
                                    <div class="bagi lebar-85">
                                        <div id="notes"></div>
                                    </div>
                                </div>
                                <div class="mt-1" id="photo"></div>
                            </div>
                        </div>`,
                        createTo: '#receiverArea'
                    });

                    select(`#receiver_${i} #receiver_name`).innerText = receiver.receiver_name;
                    select(`#receiver_${i} #receiver_phone`).innerText = receiver.receiver_phone;
                    select(`#receiver_${i} #receiver_region`).innerText = receiver.receiver_region;
                    select(`#receiver_${i} #receiver_address`).innerText = receiver.receiver_address;
                    select(`#receiver_${i} #weight`).innerText = receiver.weight;
                    select(`#receiver_${i} #dimension`).innerText = receiver.dimension;

                    if (receiver.notes != null) {
                        select(`#receiver_${i} #notes`).innerText = receiver.notes;
                    } else {
                        select(`#receiver_${i} .notesArea`).style.display = "none";
                    }

                    if (receiver.photo != null) {
                        select(`#receiver_${i} #photo`).setAttribute('bg-image', `{{ asset('storage/foto_barang') }}/${receiver.photo}`)
                        select(`#receiver_${i} #photo`).style.height = "200px";
                        bindDivWithImage();
                    }
                });
            }
        });

        e.preventDefault();
    }

    setTimeout(() => {
        let shippingCode = select("#shipping_code").value;
        if (shippingCode != "") {
            select("#formLacak button").click();
        }
    }, 1500);
</script>
@endsection