@extends('frontend.layouts.app')

@section('title') {{ __("Registrants") }} @endsection

@section('content')
<?php
    $regData = $registrant->data;
?>

<section class="section section-lg line-bottom-light bg-light">
    <div class="container z-2 mt-3">
        <div class="row">

            <div class="col-lg-12 mb-5">
                @include('flash::message')

                @if(!$registrant->error)
                <div class="card bg-white border-light shadow-soft flex-md-row no-gutters p-4">
                    <div class="card-body d-flex flex-column justify-content-between col-auto py-4 p-lg-5">
                        <h3 class="text-center mb-4">
                            Ringkasan Pendaftaran
                        </h3>
                        <div class="table">
                            <div class="row">
                                <div class="col col-md-3">
                                    <strong>ID Pendaftar</strong>
                                </div>
                                <div class="col col-md-9 text-primary font-weight-bold">
                                    : {{$regData->registrant_id}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-3">
                                    <strong>Nama</strong>
                                </div>
                                <div class="col col-md-9">
                                    : {{$regData->name}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-3">
                                    <strong>Jalur Pendaftaran</strong>
                                </div>
                                <div class="col col-md-9">
                                    : {{$regData->path->name}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-3">
                                    <strong>Kelas / Jurusan</strong>
                                </div>
                                <div class="col col-md-9">
                                    : {{$regData->tier->tier_name}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-3">
                                    <strong>No. Telp Ortu</strong>
                                </div>
                                <div class="col col-md-9">
                                    : {{$regData->phone}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-3">
                                    <strong>No. Telp Anak</strong>
                                </div>
                                <div class="col col-md-9">
                                    : {{$regData->phone2}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-3">
                                    <strong>Email Ortu</strong>
                                </div>
                                <div class="col col-md-9">
                                    : {{$regData->email}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-3">
                                    <strong>Email Anak</strong>
                                </div>
                                <div class="col col-md-9">
                                    : {{$regData->email_2}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-3">
                                    <strong>Sekolah Asal</strong>
                                </div>
                                <div class="col col-md-9">
                                    : {{$regData->former_school ?? "-"}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-3">
                                    <strong>Skema SPM</strong>
                                </div>
                                <div class="col col-md-9">
                                    : {{$regData->scheme_string}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-3">
                                    <strong>Info dari</strong>
                                </div>
                                <div class="col col-md-9">
                                    : {{$regData->info}}
                                </div>
                            </div>
                        </div>

                            <div class="row">
                                <div class="col">
                                    <small>Apabila terdapat data yang kurang tepat, silakan menghubungi admin sekolah <strong> {{$regData->unit->name}} Warga </strong> melalui nomor whatsapp 
                                            <?php
                                            $crude_number = $regData->unit->contact_number;
                                            $clean_number = \Str::replaceFirst('0','62',$crude_number);
                                            ?>
                                            <a type="" href="https://wa.me/{{$clean_number}}" id ="{{$regData->unit->id}}" class="">
                                                <i class="fab fa-lg fa-whatsapp"></i>
                                                <span class="">
                                                {{'+'.$clean_number}}
                                                </span>
                                            </a>                                    
                                    </small>
                                </div>
                            </div>
                        <hr>
                        <a href="{{ route('frontend.registrants.track') }}" target="_blank" class="btn btn-info btn-lg m-2 rounded-pill pr-4" title="cek_status"><i class="fas fa-running mx-2"></i>Cek Status </a>
                    </div>
                </div>
                @endif
            </div>

        </div>

        <div class="d-flex justify-content-center w-100 mt-3">
        </div>
    </div>
</section>

@endsection
