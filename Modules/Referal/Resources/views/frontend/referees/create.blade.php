@extends('frontend.layouts.app')

@section('title')
    {{ __("Referees") }}
@endsection

@section('content')

<section class="section-header warga-purple text-white pb-7 pb-lg-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h1 class="display-2 mb-4">
                  Program Referal
                </h1>
                <div class="row">
                    <div class="col">
                            <?php
                            $module_name = 'referees';
                            $module_action = 'Create';
                            ?>
                            {{ html()->form('POST', route("frontend.$module_name.store"))->class('form')->open() }}

                            @include('referal::frontend.referees.form',['module_name' => 'referees'])

                            <div class="row">
                                <div class="col-12">
                                    <div class="float-right">
                                        <div class="form-group">
                                        {{ html()->button($text = "<i class='fas fa-long-arrow-alt-right'></i> " . ucfirst("Daftar") . "", $type = 'submit')->class('btn btn-success btn-lg') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{ html()->form()->close() }}

                        </div>

                    @include('frontend.includes.messages')
                </div>
            </div>
        </div>
    </div>
    <div class="pattern bottom"></div>
</section>

@endsection
