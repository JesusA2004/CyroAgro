@extends('layouts.auth')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span id="card_title">{{ __('Productos') }}</span>
                        <a href="{{ route('productos.create') }}" class="btn btn-primary btn-sm">
                            {{ __('Crear nuevo') }}
                        </a>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Folio</th>
                                        <th>Nombre</th>
                                        <th>Segmento</th>
                                        <th>Categoría</th>
                                        <th>Registro</th>
                                        <th>Contenido</th>
                                        <th>Presentaciones</th>
                                        <th>Intervalo de Aplicación</th>
                                        <th>Incompatibilidad</th>
                                        <th>Certificación</th>
                                        <th>Controla</th>
                                        <th>Ficha Técnica</th>
                                        <th>Hoja Seguridad</th>
                                        <th>Precio</th>
                                        <th>Inventario</th>
                                        <th>Foto</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $producto)
                                        <tr>
                                            <td>{{ $producto->id }}</td>
                                            <td>{{ $producto->nombre }}</td>
                                            <td>{{ $producto->segmento }}</td>
                                            <td>{{ $producto->categoria }}</td>
                                            <td>{{ $producto->registro }}</td>
                                            <td>{{ $producto->contenido }}</td>
                                            <td>{{ $producto->presentaciones }}</td>
                                            <td>{{ $producto->intervalo_aplicacion }}</td>
                                            <td>{{ $producto->incompatibilidad }}</td>
                                            <td>{{ $producto->certificacion }}</td>
                                            <td>{{ $producto->controla }}</td>
                                            <td>
                                                @if($producto->ficha_tecnica)
                                                    <a href="{{ asset('archivos/' . $producto->ficha_tecnica) }}" target="_blank">Ver</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if($producto->hoja_seguridad)
                                                    <a href="{{ asset('archivos/' . $producto->hoja_seguridad) }}" target="_blank">Ver</a>
                                                @endif
                                            </td>
                                            <td>${{ number_format($producto->precio, 2) }}</td>
                                            <td>{{ $producto->cantidad_inventario }}</td>
                                            <td>
                                                @php
                                                    $localPath = public_path('ImgProductos/' . $producto->urlFoto);
                                                    $localUrl = asset('ImgProductos/' . $producto->urlFoto);
                                                    $webUrl = $producto->urlFoto;
                                                    $fallback = asset('img/defecto.png'); // Imagen genérica local
                                                @endphp

                                                @if(file_exists($localPath))
                                                    <img src="{{ $localUrl }}" alt="Foto" style="width: 60px; height: auto;">
                                                @elseif(filter_var($webUrl, FILTER_VALIDATE_URL))
                                                    <img src="{{ $webUrl }}" alt="Foto Web" style="width: 60px; height: auto;" onerror="this.onerror=null;this.src='{{ $fallback }}';">
                                                @else
                                                    <img src="{{ $fallback }}" alt="Sin imagen" style="width: 60px; height: auto;">
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('productos.show', $producto->id) }}"><i class="fa fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('productos.edit', $producto->id) }}"><i class="fa fa-edit"></i></a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {!! $productos->withQueryString()->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
