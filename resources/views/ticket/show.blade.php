@extends('layouts.app')

@section('template_title')
    {{ $ticket->name ?? __('Show') . " " . __('Ticket') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Ticket</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('tickets.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha:</strong>
                                    {{ $ticket->fecha }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Empleado Id:</strong>
                                    {{ $ticket->empleado_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Cliente Id:</strong>
                                    {{ $ticket->cliente_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Total:</strong>
                                    {{ $ticket->total }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
