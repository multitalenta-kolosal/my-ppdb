@extends('frontend.layouts.app')

@section('title') {{ __("Referees") }} @endsection

@section('content')

<section class="section-header warga-purple text-white pb-7 pb-lg-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h1 class="display-2 mb-4">
                    Area Referee
                </h1>
                <p class="lead">
                    Lihat Link Referal dan Lihat Perkembangan Referal Anda. Silakan Masukan <span class= "text-info">Email</span>
                    dan <span class= "text-info">Nomor Handphone</span>
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
                            $module_name = 'referees';
                            $module_action = 'Reftrack';
                            ?>                            
                            @csrf

                            @include('referal::frontend.referees.form-track',['module_name' => 'referees'])

                        <div class="row justify-content-center">
                            <div class="col-10">
                                <div class="form-group float-right">
                                    {{ html()->button($text = "<i class='fas fa-arrow-right'></i> " . ucfirst("Masuk") . "", $type = 'submit')->id('button-track')->class('btn btn-success btn-lg') }}
                                </div>
                            </div>
                        </div>
                
                        {{ html()->form()->close() }}
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

        if(!$('#email').val()){
            Swal.fire("@lang('Error')", "Silakan isikan data Email anda", "error");
            return;
        }
        if(!$('#phone').val()){
            Swal.fire("@lang('Error')", "Silakan isi nomor handphone yang kamu gunakan untuk mendaftar", "error");
            return;
        }

        $('#render-view').html('');
        var email = $('#email').val();
        var generateUrl = '{{ route("frontend.$module_name.refarea", 'email') }}';
        $.ajax({
            method: "POST",
            url: generateUrl,
            data:{
                "_token": "{{ csrf_token() }}",
                "email" : $('#email').val(),
                "phone" : $('#phone').val(),
            },
            success: function (data) {
                $("#spinner").show();
                if(data.error){
                    Swal.fire('Whoopss...', data.message, "error");
                    $("#spinner").hide();
                }else{
                    setTimeout(function () {
                        $('#render-view').html(data);
                        $("#spinner").hide();
                        document.getElementById("reflink-home-btn").addEventListener("click", function() {
                            copyToClipboardMsg(document.getElementById("reflink-home-target"), "msg-reflink-home-target");
                        });
                        document.getElementById("reflink-daftar-btn").addEventListener("click", function() {
                            copyToClipboardMsg(document.getElementById("reflink-daftar-target"), "msg-reflink-daftar-target");
                        });
                    }, 1000);
                    $('html, body').animate({
                        scrollTop: $("#spinner").offset().top
                    }, 1500);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                Swal.fire("@lang('error ajax')", ajaxOptions, "error");
            }
        });
    });
});

</script>

<script type="text/javascript">
    function copyToClipboardMsg(elem, msgElem) {
        var succeed = copyToClipboard(elem);
        var msg;
        if (!succeed) {
            msg = "Copy not supported or blocked.  Press Ctrl+c to copy."
        } else {
            msg = "Text copied to the clipboard."
        }
        
        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
        Toast.fire({
                        icon: 'success',
                        title: 'Link berhasil dicopy',
                    })
        setTimeout(function() {
            msgElem.innerHTML = "";
        }, 10000);
    }

    function copyToClipboard(elem) {
        // create hidden text element, if it doesn't already exist
        var targetId = "_hiddenCopyText_";
        var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
        var origSelectionStart, origSelectionEnd;
        
            // must use a temporary form element for the selection and copy
            target = document.getElementById(targetId);
            if (!target) {
                var target = document.createElement("textarea");
                target.style.position="fixed";
                target.style.left = "-9999px";
                target.style.top = "0";
                target.id = targetId;
                document.body.appendChild(target);
            }
            target.textContent = elem.textContent;
        
        // select the content
        var currentFocus = document.activeElement;
        target.focus();
        target.setSelectionRange(0, target.value.length);
        
        // copy the selection
        var succeed;
        try {
            succeed = document.execCommand("copy");
        } catch(e) {
            succeed = false;
        }
        // restore original focus
        if (currentFocus && typeof currentFocus.focus === "function") {
            currentFocus.focus();
        }
        
        if (isInput) {
            // restore prior selection
            elem.setSelectionRange(origSelectionStart, origSelectionEnd);
        } else {
            // clear temporary content
            target.textContent = "";
        }
        return succeed;
    }
</script>

@endpush