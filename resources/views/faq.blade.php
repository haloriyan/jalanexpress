@extends('layouts.page')

@section('title', "Frequently Asked Question")

@section('content')
<div class="content">
    <div class="rata-tengah mb-4">
        <h2 class="mb-0">Frequently Asked Question</h2>
        <p class="mt-1 teks-transparan">Pertanyaan yang mungkin ingin Anda tanyakan</p>
    </div>
    <div class="wrap mt-2">
        @foreach ($faqs as $faq)
            <div class="faq-item bagi lebar-50 desktop">
                <div class="wrap">
                    <div class="bg-putih rounded bayangan-5 smallPadding">
                        <div class="wrap">
                            <h2 class="mb-1">{{ $faq->question }}</h2>
                            <pre>{{ $faq->answer }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @include('components.Footer')
</div>
@endsection