@extends('layouts.public')

@section('content')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">

<div class="login-background">
    <div class="overlay-black">
        <div class="container login-container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card login-card shadow-lg animate-fade-in">
                        <div class="card-header text-center fw-bold fs-4">{{ __('Iniciar sesión') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3 row">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Correo electrónico') }}</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                               name="password" required autocomplete="current-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                {{ __('Recordarme') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-4 d-flex flex-wrap gap-2 align-items-center">
                                        <button type="submit" class="btn btn-success btn-register">
                                            {{ __('Iniciar sesión') }}
                                        </button>

                                        <a class="btn btn-outline-light" href="{{ route('register') }}">
                                            {{ __('Registrarme') }}
                                        </a>

                                        <a class="restore-link" href="{{ route('password.request') }}">
                                            {{ __('Restablecer contraseña') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- .card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
