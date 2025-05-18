@extends('layouts.app')

@section('template_title')
    {{ $detalle->name ?? __('Show') . " " . __('Detalle') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Detalle</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('detalles.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Ticket Id:</strong>
                                    {{ $detalle->ticket_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Producto Id:</strong>
                                    {{ $detalle->producto_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Cantidad:</strong>
                                    {{ $detalle->cantidad }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Precio Unit:</strong>
                                    {{ $detalle->precio_unit }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Subtotal:</strong>
                                    {{ $detalle->subtotal }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
