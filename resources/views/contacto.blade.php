@extends('layouts.public')

@push('styles')
<link href="{{ asset('css/contacto.css') }}" rel="stylesheet">
@endpush

@section('content')
<section id="contact-header" class="text-white text-center d-flex align-items-center justify-content-center">
  <div class="overlay"></div>
  <div class="container position-relative">
    <h1 class="display-5 fw-bold">Contacto</h1>
    <p class="lead">Ponte en contacto con nosotros. Estamos para ayudarte.</p>
  </div>
</section>

<section class="map-section py-5 bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="map-responsive rounded shadow">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3774.422870872!2d-99.1672079845316!3d18.912667687181873!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85ce75a0628457b9%3A0x7fc52356eb2d637e!2sCYR+AGROQUIMICA+S.A+DE+C.V!5e0!3m2!1ses-419!2smx!4v1557501148233!5m2!1ses-419!2smx" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="contact-form" class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2>Formulario de contacto</h2>
      <p class="text-muted">Por favor completa el siguiente formulario y nos pondremos en contacto contigo lo antes posible.</p>
    </div>
    <form action="#" method="POST" class="row g-4">
      <div class="col-md-4">
        <input type="text" name="name" class="form-control" placeholder="Tu nombre" required>
      </div>
      <div class="col-md-4">
        <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
      </div>
      <div class="col-md-4">
        <input type="text" name="subject" class="form-control" placeholder="Asunto" required>
      </div>
      <div class="col-12">
        <textarea name="message" class="form-control" rows="6" placeholder="Mensaje" required></textarea>
      </div>
      <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary px-5">Enviar mensaje</button>
      </div>
    </form>
  </div>
</section>
@endsection

@section('footer')
  @include('includes.footer')
@endsection