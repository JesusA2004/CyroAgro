@section('footer')
<link href="{{ asset('css/footer.css') }}" rel="stylesheet">

<footer class="footer-section mt-5" id="contact">
    <div class="container py-5">
        <div class="row gy-4">
            <div class="col-md-4">
                <div class="footer-widget">
                    <h5 class="widgetheading">Nuestras secciones</h5>
                    <ul class="link-list">
                        <li><a href="{{ route('index') }}">Inicio</a></li>
                        <li><a href="{{ route('nosotros') }}">Nosotros</a></li>
                        <li><a href="{{ route('productos.index') }}">Productos</a></li>
                        <li><a href="{{ route('contacto') }}">Contacto</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <div class="footer-widget">
                    <h5 class="widgetheading">Información Importante</h5>
                    <ul class="link-list">
                        <li><a href="#">Términos y condiciones</a></li>
                        <li><a href="#">Aviso de privacidad</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <div class="footer-widget">
                    <h5 class="widgetheading">Contacto</h5>
                    <address>
                        <strong>CYR AGROQUIMICA SA DE CV</strong><br>
                        Av. 56 Sur No. 4 Int. 9<br>
                        Col. El Pedregal<br>
                        Jiutepec, Morelos
                    </address>
                    <p>
                        <i class="fas fa-phone"></i> +52(777)321-8657<br>
                        <i class="fas fa-envelope"></i> Contacto@cyr-agroquimica.com
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="sub-footer py-3">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start">
            <div class="copyright">
                &copy; CYR AGROQUÍMICA S.A. DE C.V. - Todos los derechos reservados.
            </div>
        </div>
    </div>
</footer>
@endsection
