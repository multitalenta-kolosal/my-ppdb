@extends('frontend.layouts.app')

@section('title') {{ __("Registrants") }} @endsection

@section('content')

<section class="section-header bg-indigo text-white pb-7 pb-lg-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h1 class="display-2 mb-4">
                    Daftar Link Verifikasi
                </h1>
                <p class="lead">
                </p>
            </div>
        </div>
    </div>
    <div class="pattern-soft bottom"></div>
</section>

<section class="section section-lg line-bottom-light bg-light">
    <div class="container mt-n7 mt-lg-n12 z-2">
        <div class="row">
                <div class="col-lg-12 mb-5">
                    <div class="card bg-white border-light shadow-soft p-3">
                        @foreach($units as $unit)
                            <div class="row card border-purple rounded shadow m-2">
                                <div class="col-5 m-3">
                                    <h3>{{$unit->name}}</h3>
                                    @if($unit->register_form_link)
                                        <a href="{{$unit->register_form_link}}" class="btn btn-primary"><i class="fas fa-user-check"></i> Form Verifikasi</a>
                                    @else
                                        <button class="btn btn-gray" disabled><i class="fas fa-user-check"></i> Form Verifikasi</button>
                                        <p class="text-warning">Verifikasi Online tidak tersedia</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

        </div>
    </div>
</section>

@endsection
