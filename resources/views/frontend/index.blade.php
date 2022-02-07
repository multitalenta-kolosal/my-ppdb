@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<section class="section-header pb-6 pb-lg-6 warga-purple text-white">
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
                <p class="lead text-info">
                    Pastikan anda memasukkan nomor telepon dengan benar supaya sistem
                    kami dapat berkomunikasi dengan anda melalui pesan Whatsapp
                </p>
            </div>
            @include('registrant::frontend.registrants.create')

        </div>
    </div>
</section>

<section class="section section-ld bg-body" id="info_unit">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="mb-4 mb-lg-5">Website Unit</h2>
                <p class="lead text-info">
                    Kunjungi Website Unit Pendidikan Kami untuk Mendapatkan Informasi Terbaru!
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-4 col-sm-6 text-center m-3">
                <div class="card p-4 shadow">
                    <a href="https://kbtk.warga.sch.id">
                        <h2 class="mb-4 mb-lg-5 text-warning">KB/TK</h2>
                    </a>
                    <a class="btn btn-warning"href="https://kbtk.warga.sch.id">
                        Klik disini
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 text-center m-3">
                <div class="card p-4 shadow">
                    <a href="https://sdwarga.sch.id">
                        <h2 class="mb-4 mb-lg-5 text-success">SD</h2>
                    </a>
                    <a class="btn btn-success" href="https://sdwarga.sch.id">
                        Klik disini
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 text-center m-3">
                <div class="card p-4 shadow">
                    <a href="https://smpwarga.sch.id">
                        <h2 class="mb-4 mb-lg-5 text-danger">SMP</h2>
                    </a>
                    <a class="btn btn-primary" href="https://smpwarga.sch.id">
                        Klik disini
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 text-center m-3">
                <div class="card p-4 shadow">
                    <a href="https://smawarga.sch.id">
                        <h2 class="mb-4 mb-lg-5 text-primary">SMA</h2>
                    </a>
                    <a class="btn btn-danger" href="https://smawarga.sch.id">
                        Klik disini
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 text-center m-3">
                <div class="card p-4 shadow">
                    <a href="https://smkwarga-slo.sch.id">
                        <h2 class="mb-4 mb-lg-5 text-purple">SMK</h2>
                    </a>
                    <a class="btn btn-purple" href="https://smkwarga-slo.sch.id">
                        Klik disini
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

