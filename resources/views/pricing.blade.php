@extends('layouts.page')

@section('title', "Tarif")

@php
    use Carbon\Carbon;
@endphp
    
@section('content')
<div class="content">
    <div class="wrap">
        <h2 class="mt-0 rata-tengah">Ongkos Kirim</h2>
        @foreach ($schedules as $key => $schedule)
            @php
                $times = [];
                foreach ($schedule['times'] as $time) {
                    $t = Carbon::parse($time)->format("H:i");
                    array_push($times, $t);
                }
            @endphp
            <div class="bagi bagi-3 desktop mb-3">
                <div class="wrap">
                    <div class="bg-putih bayangan-5 smallPadding rata-tengah">
                        <div class="wrap super">
                            <h3>{{ $key }}</h3>
                            <div class="mb-3">@currencyEncode($schedule['price'])</div>

                            {{ implode(" - ", $times) }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @include('components.Footer')
</div>
@endsection