@extends('frontend.layouts.app')

@section('title') {{ __("Registrants") }} @endsection

@section('content')

<section class="section-header warga-purple text-white pb-7 pb-lg-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h1 class="display-2 mb-4">
                    Cek Status
                </h1>
                <p class="lead">
                    Ingin melihat progres anda atau bingung apa yang harus dilakukan? Lihat status anda dengan menggunakan data <span class= "text-info">ID Pendaftaran</span>
                    dan <span class= "text-info">Nomor Telepon</span>
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
             
            <div class="col-lg-12 mb-5">
                <div class="card bg-white border-light shadow-soft flex-md-row no-gutters p-2">
                    </a>
                    <div class="card-body d-flex flex-column justify-content-between col-auto py-4 p-lg-5">
                        <div class="col">
                            <?php
                            $module_name = 'registrants';
                            $module_action = 'Track';
                            ?>                            
                            @csrf

                            @include('registrant::frontend.registrants.form-track',['module_name' => 'registrants'])

                        <div class="row justify-content-center">
                            <div class="col-10">
                                <div class="form-group float-right">
                                    {{ html()->button($text = "<i class='fas fa-search'></i> " . ucfirst("Cari") . "", $type = 'submit')->id('button-track')->class('btn btn-success btn-lg') }}
                                </div>
                            </div>
                        </div>
                
                        {{ html()->form()->close() }}

                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" id="spinner" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>

                        <div class="justify-content-between col-auto z-3">
                            <div id="render-view">
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>            
    </div>

</section>

@endsection

@push('after-scripts')
<script type="text/javascript">

$(document).ready(function(){
    $("#spinner").hide();
    $("#button-track").on("click", function (event) {

        $('#render-view').html('');
        var registrant_id = $('#registrant_id').val();
        var generateUrl = '{{ route("frontend.$module_name.progress", 'registrant_id') }}';
        $.ajax({
            method: "POST",
            url: generateUrl,
            data:{
                "_token": "{{ csrf_token() }}",
                "registrant_id" : $('#registrant_id').val(),
                "phone" : $('#phone').val(),
            },
            success: function (data) {
                $("#spinner").show();
                if(data.error){
                    Swal.fire("@lang('error')", "@lang('Error')", "error");
                    $("#spinner").hide();
                }else{
                    setTimeout(function () {
                        $('#render-view').html(data);
                        $("#spinner").hide();
                    }, 1000);
                    $('html, body').animate({
                        scrollTop: $("#spinner").offset().top
                    }, 1500);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                Swal.fire("@lang('error')", "@lang('Error')", "error");
            }
        });
    });
});
</script>
@endpush