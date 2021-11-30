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
                        <td>
                            <span class="bg-hijau-transparan rounded p-1 pl-2 pr-2 pointer" onclick="edit('{{ $courier }}')">
                                <i class="fas fa-edit"></i>
                            </span>
                        </td>
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
                <i class="fas fa-times ke-kanan pointer" onclick="hilangPopup('#addCourier')"></i>
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

<div class="popupWrapper" id="editCourier">
    <div class="popup">
        <div class="wrap">
            <h3>Edit Courier
                <i class="fas fa-times ke-kanan pointer" onclick="hilangPopup('#editCourier')"></i>
            </h3>
            <form action="{{ route('admin.courier.update') }}" method="POST" enctype="multipart/form-data" class="wrap super">
                {{ csrf_field() }}
                <input type="hidden" name="id" id="id">
                <div class="mt-2">Name :</div>
                <input type="text" class="box" name="name" id="name" required>
                <div class="mt-2">Telepon :</div>
                <input type="text" class="box" name="phone" id="phone" required>
                <div class="mt-2">Password :</div>
                <input type="password" class="box" name="password" id="password">
                <div class="mt-1 teks-kecil teks-transparan">biarkan kosong jika tidak ingin mengubah password</div>

                <button class="mt-3 lebar-100 hijau">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    const edit = data => {
        data = JSON.parse(data);
        munculPopup("#editCourier");
        select("#editCourier #id").value = data.id;
        select("#editCourier #name").value = data.name;
        select("#editCourier #phone").value = data.phone;
    }
</script>
@endsection