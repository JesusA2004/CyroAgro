@extends('layouts.auth')

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">{{ isset($producto->id) ? 'Modificar' : 'Crear' }} Producto</span>
                </div>
                <div class="card-body bg-white">
                    <form method="POST" action="{{ isset($producto->id) ? route('productos.update', $producto->id) : route('productos.store') }}" role="form" enctype="multipart/form-data">
                        @csrf
                        @if(isset($producto->id)) @method('PATCH') @endif
                        @include('producto.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection