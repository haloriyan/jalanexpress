@extends('layouts.admin')

@section('title', "FAQ")

@section('header.action')
<button class="hijau" onclick="munculPopup('#addFaq')">
    <i class="fas fa-plus mr-1"></i> FAQ
</button>
@endsection

@section('content')
<div class="bg-putih rounded bayangan-5 smallPadding">
    <div class="wrap">
        <table>
            <thead>
                <tr>
                    <th>Pertanyaan</th>
                    <th>Jawaban</th>
                    <th class="lebar-20"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($faqs as $faq)
                    <tr>
                        <td>{{ $faq->question }}</td>
                        <td>{{ $faq->answer }}</td>
                        <td>
                            <span class="bg-hijau-transparan rounded p-1 pl-2 pr-2 pointer" onclick="edit('{{ $faq }}')">
                                <i class="fas fa-edit"></i>
                            </span>
                            <a class="bg-merah-transparan rounded ml-1 p-1 pl-2 pr-2" href="{{ route('admin.faq.delete', $faq->id) }}" onclick="return confirm('Yakin ingin menghapus item ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="bg"></div>
<div class="popupWrapper" id="addFaq">
    <div class="popup">
        <div class="wrap">
            <h3>Tambah FAQ
                <i class="fas fa-times ke-kanan pointer" onclick="hilangPopup('#addFaq')"></i>
            </h3>
            <form action="{{ route('admin.faq.store') }}" method="POST" class="wrap super">
                {{ csrf_field() }}
                <div class="mt-2">Pertanyaan :</div>
                <input type="text" class="box" name="question" required>
                <div class="mt-2">Jawaban :</div>
                <textarea name="answer" id="answer" class="box" required></textarea>
                <button class="lebar-100 mt-3 hijau">Simpan</button>
            </form>
        </div>
    </div>
</div>

<div class="popupWrapper" id="editFaq">
    <div class="popup">
        <div class="wrap">
            <h3>Edit FAQ
                <i class="fas fa-times ke-kanan pointer" onclick="hilangPopup('#editFaq')"></i>
            </h3>
            <form action="{{ route('admin.faq.update') }}" method="POST" class="wrap super">
                {{ csrf_field() }}
                <input type="hidden" name="id" id="id">
                <div class="mt-2">Pertanyaan :</div>
                <input type="text" class="box" name="question" id="question" required>
                <div class="mt-2">Jawaban :</div>
                <textarea name="answer" id="answer" class="box" required></textarea>
                <button class="lebar-100 mt-3 hijau">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    const edit = data => {
        data = JSON.parse(data);
        munculPopup("#editFaq");
        select("#editFaq #id").value = data.id;
        select("#editFaq #question").value = data.question;
        select("#editFaq #answer").value = data.answer;
    }
</script>
@endsection