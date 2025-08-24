@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ isset($producto->id) ? route('producto.update', $producto->id) : route('producto.store') }}" role="form" enctype="multipart/form-data">
        @csrf
        @if(isset($producto->id)) @method('PATCH') @endif

        @include('producto.form')
    </form>
@endsection

@push('styles')
    <link href="{{ asset('css/formProducto.css') }}" rel="stylesheet">
@endpush

@push('scripts')

    <script> 
        const fotoInput = document.getElementById('foto');
        const previewImage = document.getElementById('previewImage');
        const removeBtn = document.querySelector('.remove-image-btn');

        const DEFAULT_IMAGE = "{{ asset('img/generica.png') }}";

        fotoInput?.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        removeBtn?.addEventListener('click', function () {
            previewImage.src = DEFAULT_IMAGE;
            fotoInput.value = '';
        });
    </script>

    <script src="{{ asset('js/previewFotoProducto.js') }}"></script>

@endpush
