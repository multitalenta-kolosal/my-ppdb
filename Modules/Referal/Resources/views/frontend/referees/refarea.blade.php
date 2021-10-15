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
                    Lihat Link Referal dan Lihat Perkembangan Referal Anda
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
                <div class="card bg-white border-light shadow-soft flex-md-row no-gutters p-2">
                    </a>
                    <div class="card-body d-flex flex-column justify-content-between col-auto py-4 p-lg-5">
                        <div class="justify-content-between col-auto z-3">
                            <div>
                                <div class="row py-1 my-3 text-center justify-content-center align-middle">
                                    <div class="col-sm-6 col-md-6">
                                        <h4 class="text-primary display-3">{{$referee->data->name ?? 'DATA NOT FOUND'}}</h4>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <span class="display-4">Link Referal:</span>
                                </div>
                                <div class="row py-3 my-3 shadow border border-primary rounded text-center justify-content-center">
                                    <div class="col">
                                        <div class="row align-middle">
                                            <div class="col text-center">
                                                <strong class="display-5 text-info">
                                                    <a href="{{url('/?ref='.$referee->data->ref_code)}}">
                                                        <span id="reflink-home-target" style="position:relative">
                                                            <u>{{url('/?ref='.$referee->data->ref_code)}}</u>
                                                        </span>
                                                    </a>
                                                </strong>
                                                <button class="btn btn-sm btn-danger" id="reflink-home-btn"><i class='fas fa-copy mr-1'></i>Copy</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-1 my-3 shadow border border-dark rounded text-center justify-content-center">
                                    @include('referal::frontend.referees.show')
                                </div>
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

    document.getElementById("reflink-home-btn").addEventListener("click", function() {
        copyToClipboardMsg(document.getElementById("reflink-home-target"), "msg-reflink-home-target");
    });

    document.getElementById("reflink-daftar-btn").addEventListener("click", function() {
        copyToClipboardMsg(document.getElementById("reflink-daftar-target"), "msg-reflink-daftar-target");
    });

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
