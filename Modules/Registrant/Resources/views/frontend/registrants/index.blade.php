@extends('frontend.layouts.app')

@section('title') {{ __("Registrants") }} @endsection

@section('content')

<section class="section-header warga-purple text-white pb-7 pb-lg-11">
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="/img/content/car1.webp" alt="First slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="/img/content/car2.webp" alt="Second slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="/img/content/car3.webp" alt="Third slide">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-md-8 text-center">
                <h1 class="display-2 mb-4">
                   Pendaftaran Peserta
                </h1>
                <p class="lead">
                    Pastikan anda memasukkan nomor telepon dengan benar supaya sistem
                    kami dapat berkomunikasi dengan anda melalui pesan Whatsapp
                </p>

                @include('frontend.includes.messages')
            </div>
        </div>
    </div>
    <div class="pattern-soft bottom"></div>
</section>

<section class="section section-lg line-bottom-light bg-light">
    <div class="container mt-n7 mt-lg-n12 z-2">
        <div class="row">
             <img class="d-block my-3" src="/img/content/jalur_istimewa.webp" alt="Jalur Istimewa">

            <div class="col-lg-12 mb-5">
                <div class="card bg-white border-light shadow-soft flex-md-row no-gutters p-4">
                    
                    <div class="card-body d-flex flex-column justify-content-between col-auto py-4 p-lg-5">
                        <h5 class="text-center mb-4">
                            Form pendaftaran
                        </h5>
                        @include('registrant::frontend.registrants.create')
                    </div>
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-center w-100 mt-3">
        </div>
    </div>
</section>

@endsection
