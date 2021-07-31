@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<section class="section-header pb-6 pb-lg-6 bg-indigo text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 text-center">
                <h1 class="display-1 mb-4">{{app_name()}}</h1>
                <p class="lead text-muted">
                    {!! setting('meta_description') !!}
                </p>
                <a href="#form_pendaftaran" class="btn btn-secondary btn-lg m-2 rounded-pill pr-4" title="pendaftaran"><i class="fas fa-file-signature mx-2"></i> Daftar</a>
                <a href="{{ route('frontend.registrants.track') }}" class="btn btn-info btn-lg m-2 rounded-pill pr-4" title="cek_status"><i class="fas fa-running mx-2"></i>Cek Status</a>
                @include('frontend.includes.messages')
            </div>
        </div>
    </div>
</section>

<section class="section section-ld bg-body" id="form_pendaftaran">
    <div class="container">
        <div class="row">
            @include('flash::message')
            <div class="col-12 text-center">
                <h2 class="mb-4 mb-lg-5">Pendaftaran Peserta</h2>
            </div>
            @include('registrant::frontend.registrants.create')

        </div>
    </div>
</section>

@endsection

