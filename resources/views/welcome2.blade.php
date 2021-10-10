<!DOCTYPE html>
<html lang="es">
<!-- Copied from http://radixtouch.in/templates/admin/aegis/source/light/carousel.html by Cyotek WebCopy 1.7.0.600, Saturday, September 21, 2019, 2:51:57 AM -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>INICIO</title>
    <!-- General CSS Files -->
    @laravelPWA
    <link rel="stylesheet" href=" {{ asset('aegis/source/light/assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('aegis/source/light/assets/css/style.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('aegis/source/light/assets/img/icono.ico') }}">
  
</head>

<body>
    <header>
           
                <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <video class="embed-responsive-item w-100 " height="" autoplay loop>
                                <source src="digital/mp4/video.mp4" type="video/mp4">
                            </video>
                            {{-- <div class="carousel-caption d-none d-md-block">
                                <h5>SOLUTIONFINANCETAX</h5>
                                <a href="{{ url('/page') }}" class="btn btn-dark btn-lg btn-block" role="button"
                                aria-pressed="true">EMPIEZA AHORA</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            
    </header>

    <section class="my-5">
        <div class="container-sm">
            <div class="d-grid gap-2 col-6 mx-auto">
                <h5 align="center">
                    SOLUTIONFINANCETAX
                </h5>
                <a href="{{ url('/page') }}" class="btn btn-dark btn-lg btn-block" role="button"
                    aria-pressed="true">EMPIEZA AHORA</a>
            </div>
        </div>
    </section>

    {{-- <section>
        <div class="card">
            <div class="card-body">
                <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <video class="embed-responsive-item w-100 " height="" autoplay loop>
                                <source src="digital/mp4/video.mp4" type="video/mp4">
                            </video>
                            <div class="carousel-caption d-none d-md-block">
                                <h5>SOLUTIONFINANCETAX</h5>
                                <a href="{{ url('/page') }}" class="btn btn-dark btn-lg btn-block" role="button"
                                aria-pressed="true">EMPIEZA AHORA</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- General JS Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>


</html>
