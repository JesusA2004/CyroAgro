@extends('layouts.public')

@section('content')
@push('styles')
    <link href="{{ asset('css/nosotros.css') }}" rel="stylesheet">
@endpush

<section class="hero-section text-center d-flex align-items-center justify-content-center">
    <div class="overlay"></div>
    <div class="container position-relative z-1">
        <h3 class="display-5 fw-bold text-white section-title">¿Quiénes somos?</h3>
        <div class="divider mx-auto mb-3"></div>
        <p class="lead text-light">Conoce nuestra misión, visión y al equipo que hace posible nuestro compromiso con el campo mexicano</p>
    </div>
</section>

<section id="about" class="py-5 mt-5 bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 animate-fadein">
                <h2 class="section-title"><strong>Misión</strong></h2>
                <p class="texto-justificado">Ser una empresa de Primer Nivel en su calidad de operación y capacidad de apoyo a los Agricultores, para que puedan producir eficientemente, asesorándolos y promoviendo nuestra línea de productos Agroquímicos y Orgánicos a través de nuestros representantes y distribuidores a lo largo de la República.</p>
                <p class="texto-justificado">Proveer de manera eficiente el paquete tecnológico más adecuado para el suministro correcto a los cultivos de nuestros clientes, y así permitir el desarrollo competitivo de una agricultura saludable en nuestro país.</p>

                <h2 class="section-title mt-4"><strong>Objetivo</strong></h2>
                <p class="texto-justificado">Lograr la presencia de nuestra línea de productos Agroquímicos y Orgánicos con los productores en todas las regiones donde exista potencial de aplicación, mejorando la productividad de nuestros clientes.</p>
            </div>

            <div class="col-lg-6 animate-slidein">
                <div id="aboutCarousel" class="carousel slide rounded shadow" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach(['lab1.jpg', 'lab2.jpg', 'lab3.jpg'] as $img)
                        <div class="carousel-item @if($loop->first) active @endif">
                            <img src="{{ asset('img/carruselAbout/' . $img) }}" class="d-block w-100" alt="Imagen laboratorio">
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#aboutCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#aboutCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="mapa-cyr" class="bg-white py-5">
    <div class="container text-center">
        <h2 class="section-title mb-5">Cobertura Nacional</h2>
        <p class="lead mb-5">Pasa el mouse por cada zona para conocer a nuestros representantes</p>
        <div class="mapa-container mx-auto" style="max-width: 900px;">
            @include('includes.mapa-mexico')
        </div>
        <div id="info-zona" class="mt-4 fw-bold fs-5 text-primary"></div>
    </div>

    <div id="tarjeta-zona" class="card shadow-lg px-4 py-3 text-start mx-auto mt-4" style="display: none; max-width: 400px;">
        <h5 id="titulo-zona" class="fw-bold text-success mb-2"></h5>
        <p class="mb-1"><strong>Representante:</strong> <span id="nombre-rep"></span></p>
        <p class="mb-1"><strong>Teléfono:</strong> <span id="tel-rep"></span></p>
        <p class="mb-0"><strong>Correo:</strong> <span id="correo-rep"></span></p>
    </div>

    <div class="clearfix mb-5"></div> <!-- Evita que el footer se encime -->
</section>

@endsection

@push('scripts')
<script>
const zonas = {
  'Zona Noroeste': {
    estados: ['MXSON', 'MXSIN', 'MXCHH'],
    nombre: 'Maira Olivas Olivas',
    tel: '7772338212',
    correo: 'maira@ultraquimia.com'
  },
  'Zona Bajío': {
    estados: ['MXGUA', 'MXQRO', 'MXSLP', 'MXMIC'],
    nombre: 'Gustavo Rico Resendiz',
    tel: '7773841658',
    correo: 'gustavo.cyr@hotmail.com'
  },
  'Zona Centro': {
    estados: ['MXCMX', 'MXMOR', 'MXPUE', 'MXMEX'],
    nombre: 'Oficina',
    tel: '7773218657 / 7773271756',
    correo: 'rosascordero@yahoo.com.mx'
  },
  'Zona Sureste': {
    estados: ['MXVER', 'MXCHP', 'MXOAX', 'MXTAB', 'MXCAM', 'MXYUC', 'MXROO'],
    nombre: 'Mario Alejos Peraza',
    tel: '9992400412',
    correo: 'mariopti@hotmail.com'
  },
  'Zona Baja California': {
    estados: ['MXBCN', 'MXBCS'],
    nombre: 'Gabriel Hernández',
    tel: '6161010081',
    correo: 'ing_gabihz@hotmail.com'
  }
};

// Asigna eventos a cada estado
Object.entries(zonas).forEach(([zona, info]) => {
  info.estados.forEach(id => {
    const estado = document.getElementById(id);
    if (estado) {
      estado.style.cursor = 'pointer';

      estado.addEventListener('mouseenter', () => {
        // Pintar todos los estados de esa zona
        info.estados.forEach(eid => {
          const e = document.getElementById(eid);
          if (e) e.style.fill = '#FDD835'; // amarillo CYR
        });

        // Mostrar tarjeta
        document.getElementById('titulo-zona').textContent = zona;
        document.getElementById('nombre-rep').textContent = info.nombre;
        document.getElementById('tel-rep').textContent = info.tel;
        document.getElementById('correo-rep').textContent = info.correo;

        document.getElementById('tarjeta-zona').style.display = 'block';
      });

      estado.addEventListener('mouseleave', () => {
        // Restaurar color
        info.estados.forEach(eid => {
          const e = document.getElementById(eid);
          if (e) e.style.fill = ''; // color por defecto del mapa
        });

        // Ocultar tarjeta
        document.getElementById('tarjeta-zona').style.display = 'none';
      });
    }
  });
});
</script>
@endpush

@section('footer')
    @include('includes.footer')
@endsection
