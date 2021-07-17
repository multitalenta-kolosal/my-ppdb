@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<section class="section-header pb-6 pb-lg-6 bg-primary text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 text-center">
                <h1 class="display-1 mb-4">{{app_name()}}</h1>
                <p class="lead text-muted">
                    {!! setting('meta_description') !!}
                </p>

                @include('frontend.includes.messages')
            </div>
        </div>
    </div>
</section>

<section class="section section-ld bg-body">
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
