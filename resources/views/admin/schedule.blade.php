@extends('layouts.admin')

@section('title', "Schedule")
    
@section('header.action')
<button class="hijau" onclick="munculPopup('#addSchedule')">
    <i class="fas fa-plus mr-1"></i> Schedule
</button>
@endsection

@section('content')
<div class="bg-putih rounded bayangan-5 smallPadding">
    <div class="wrap">
        <table>
            <thead>
                <tr>
                    <th>Region</th>
                    <th><i class="fas fa-clock"></i></th>
                    <th><i class="fas fa-money-bill-alt"></i></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    <tr>
                        <td>
                            {{ $schedule->region }}
                            <div class="mt-1 teks-kecil">{{ $schedule->max_orders }} max orders</div>
                        </td>
                        <td>{{ $schedule->time }}</td>
                        <td>{{ $schedule->price }}</td>
                        <th>
                            <span class="pointer teks-hijau" onclick="edit('{{ $schedule }}')">
                                <i class="fas fa-edit"></i>
                            </span>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="bg"></div>
<div class="popupWrapper" id="addSchedule">
    <div class="popup" style="width: 70%">
        <div class="wrap">
            <h3>Add New Schedule
                <i class="fas fa-times ke-kanan pointer" onclick="hilangPopup('#addSchedule')"></i>
            </h3>
            <form action="{{ route('admin.schedule.store') }}" method="POST" class="wrap">
                {{ csrf_field() }}
                <div class="bagi bagi-3">
                    <div class="mt-2">Price :</div>
                    <input type="number" class="box" name="price" id="price" required>
                </div>
                <div class="bagi bagi-3">
                    <div class="mt-2">Time :</div>
                    <input type="time" class="box" name="time" id="time" required>
                </div>
                <div class="bagi bagi-3">
                    <div class="mt-2">Max Orders :</div>
                    <input type="number " class="box" name="max_orders" id="max_orders" required>
                </div>
                
                <div class="mt-2">Region :</div>
                <select name="region" id="region" class="box" required>
                    <option value="">-- SELECT --</option>
                    <option>SURABAYA PUSAT</option>
                    <option>SURABAYA TIMUR</option>
                    <option>SURABAYA BARAT</option>
                    <option>SURABAYA UTARA</option>
                    <option>SURABAYA SELATAN</option>
                </select>

                <button class="hijau lebar-100 mt-3">Submit</button>
            </form>
        </div>
    </div>
</div>

<div class="popupWrapper" id="editSchedule">
    <div class="popup" style="width: 70%">
        <div class="wrap">
            <h3>Edit Schedule
                <i class="fas fa-times ke-kanan pointer" onclick="hilangPopup('#editSchedule')"></i>
            </h3>
            <form action="{{ route('admin.schedule.update') }}" method="POST" class="wrap">
                {{ csrf_field() }}
                <input type="hidden" name="id" id="id">
                <div class="bagi bagi-3">
                    <div class="mt-2">Price :</div>
                    <input type="number" class="box" name="price" id="price" required>
                </div>
                <div class="bagi bagi-3">
                    <div class="mt-2">Time :</div>
                    <input type="time" class="box" name="time" id="time" required>
                </div>
                <div class="bagi bagi-3">
                    <div class="mt-2">Max Orders :</div>
                    <input type="number " class="box" name="max_orders" id="max_orders" required>
                </div>
                
                <div class="mt-2">Region :</div>
                <select name="region" id="region" class="box" required>
                    <option value="">-- SELECT --</option>
                    <option value="SURABAYA PUSAT">SURABAYA PUSAT</option>
                    <option value="SURABAYA TIMUR">SURABAYA TIMUR</option>
                    <option value="SURABAYA BARAT">SURABAYA BARAT</option>
                    <option value="SURABAYA UTARA">SURABAYA UTARA</option>
                    <option value="SURABAYA SELATAN">SURABAYA SELATAN</option>
                </select>

                <button class="hijau lebar-100 mt-3">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    const edit = data => {
        data = JSON.parse(data);
        munculPopup("#editSchedule");

        select("#editSchedule #id").value = data.id;
        select("#editSchedule #time").value = data.time;
        select("#editSchedule #price").value = data.price;
        select("#editSchedule #max_orders").value = data.max_orders;
        select(`#editSchedule #region option[value='${data.region}']`).selected = true;
    }
</script>
@endsection