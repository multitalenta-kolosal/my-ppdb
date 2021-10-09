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
                    <p class="lead">
                    Masuk ke Area Referee atau <a href="#form_referee"><strong>Daftar</strong></a> dengan menggunakan form di bawah
                    </p>
                    <div class="card bg-gray-dark border border-soft">
                        <div class="card-body px-lg-8 py-lg-5">
                            <H3>
                                Area Referee
                            </H3>
                            <div class="text-center text-muted mb-4">
                                <small>Masuk dengan Email dan Nomor HP</small>
                            </div>

                            @include('flash::message')

                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <p>
                                    <i class="fas fa-exclamation-triangle"></i> @lang('Please fix the following errors & try again!')
                                </p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif

                            <form role="form" method="POST" action="{{ route('frontend.referees.refarea') }}">
                                @csrf

                                <!-- redirectTo URL -->
                                <!-- <input type="hidden" name="redirectTo" value="{{ request()->redirectTo }}"> -->

                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('Email') }}" aria-label="email" aria-describedby="input-email" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="@lang('No. Handphone')" aria-label="@lang('No. Handphone')" aria-describedby="input-password" required>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary mt-2">
                                        @lang('Masuk')
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <strong>--atau--</strong>
                    </div>
                     <a href="#form_referee" class="btn btn-danger btn-sm m-2 rounded-pill px-5" title="pendaftaran">Daftar</a>
                </div>

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
                    <div class="card-body d-flex flex-column justify-content-between col-auto py-4 p-lg-5">
                        <H3 class="text-center mb-4">
                            Pendaftaran Referee
                        </H3>
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
