@section('footer')
<link href="{{ asset('css/footer.css') }}" rel="stylesheet">

<footer class="footer-section mt-5">
    <div class="container py-5">
        <div class="row gy-4">
            <div class="col-md-4">
                <div class="footer-widget">
                    <h5 class="widgetheading">Nuestras secciones</h5>
                    <ul class="link-list">
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="about.php">Nosotros</a></li>
                        <li><a href="productos.php?Segmento_ID=1">Agroquímicos</a></li>
                        <li><a href="productos.php?Segmento_ID=2">Orgánicos</a></li>
                        <li><a href="contact.php">Contacto</a></li>
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
                        <i class="fas fa-phone"></i> +52(777)321-8657 / +52(777)321-8658<br>
                        <i class="fas fa-phone"></i> 800-6400486 / 800-6679550<br>
                        <i class="fas fa-envelope"></i> agroquimica.cyr@gmail.com
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
            <div class="social-icons mt-3 mt-md-0">
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
</footer>
@endsection
