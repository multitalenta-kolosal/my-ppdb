@extends('frontend.layouts.app')

@section('title') {{ __("Referees") }} @endsection

@section('content')

<section class="section-header warga-purple text-white pb-7 pb-lg-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h1 class="display-2 mb-4">
                  Program Referal
                </h1>
                <div class="row justify-content-center">
                     <a href="{{route('frontend.referees.reftrack')}}" class="btn btn-primary btn-lg m-2 rounded-pill px-5" title="pendaftaran">Masuk</a>
                     <div class="col-sm-10">
                        <strong>--atau--</strong>
                    </div>
                     <a href="#form_referee" class="btn btn-danger btn-sm m-2 rounded-pill px-5" title="pendaftaran">Daftar</a>
                </div>
                <p class="lead">
                   Masuk ke Area Referee atau <a href="#form_referee"><strong>Daftar</strong></a> dengan menggunakan form di bawah ini
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
             
            <div class="col-lg-12 mb-5" id="form_referee"> 
                <div class="card bg-white border-light shadow-soft flex-md-row no-gutters p-4">
                    </a>
                    <div class="card-body d-flex flex-column justify-content-between col-auto py-4 p-lg-5">
                        @include('referal::frontend.referees.create')
                    </div>
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-center w-100 mt-3">
        </div>
    </div>
</section>

@endsection
