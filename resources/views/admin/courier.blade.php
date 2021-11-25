@extends('layouts.admin')

@section('title', "Courier")

@section('header.action')
<button class="hijau" onclick="munculPopup('#addCourier')">
    <i class="fas fa-plus mr-1"></i> Courier
</button>
@endsection
    
@section('content')
<div class="bg-putih rounded bayangan-5 smallPadding">
    <div class="wrap">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($couriers as $courier)
                    <tr>
                        <td>{{ $courier->name }}</td>
                        <td>{{ $courier->phone }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="bg"></div>
<div class="popupWrapper" id="addCourier">
    <div class="popup">
        <div class="wrap">
            <h3>Add New Courier
                <i class="fas fa-times ke-kanan pointer" onclick="hilangPopup('#addCouriers')"></i>
            </h3>
            <form action="{{ route('admin.courier.store') }}" method="POST" enctype="multipart/form-data" class="wrap super">
                {{ csrf_field() }}
                <div class="mt-2">Name :</div>
                <input type="text" class="box" name="name" required>
                <div class="mt-2">Telepon :</div>
                <input type="text" class="box" name="phone" required>
                <div class="mt-2">Password :</div>
                <input type="password" class="box" name="password" required>

                <button class="mt-3 lebar-100 hijau">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection