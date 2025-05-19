@extends('layouts.auth')

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Usuario</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('usuarios.index') }}"> {{ __('Regresar') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>ID:</strong>
                            {{ $user->id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Nombre:</strong>
                            {{ $user->name }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Email:</strong>
                            {{ $user->email }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Rol:</strong>
                            {{ ucfirst($user->role) }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Fecha de creación:</strong>
                            {{ $user->created_at }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Última actualización:</strong>
                            {{ $user->updated_at }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
