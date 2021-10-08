<div>
    <h2 class="display-3 mb-3 text-center">
       -- Area Referee --
    </h2>
    <div class="row py-1 my-3 text-center justify-content-center align-middle">
        <div class="col-sm-6 col-md-6">
            <h4 class="text-primary display-3">{{$referee->data->name ?? 'DATA NOT FOUND'}}</h4>
        </div>
    </div>
    <div class="text-center">
        <span class="display-4">Link Referal:</span>
    </div>
    <div class="row py-1 my-3 shadow border border-primary rounded text-center justify-content-center">
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
                        <br>
                    <button class="btn btn-sm btn-primary" id="reflink-home-btn"><i class='fas fa-copy mr-1'></i>Copy</button>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <strong class=" text-dark">
                            <span id="atau" style="position:relative">
                                Atau
                            </span>
                    </strong>
                </div>
            </div>
            <div class="row align-middle">
                <div class="col text-center">
                        <strong class="display-5 text-info">
                            <a href="{{url('daftar/?ref='.$referee->data->ref_code)}}">
                                <span id="reflink-daftar-target" style="position:relative">
                                    <u>{{url('daftar/?ref='.$referee->data->ref_code)}}</u>
                                </span>
                            </a>
                        </strong>
                        <br>
                    <button class="btn btn-sm btn-primary" id="reflink-daftar-btn"><i class='fas fa-copy mr-1'></i>Copy</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row py-1 my-3 shadow border border-dark rounded text-center justify-content-center">
        @include('referal::frontend.referees.show')
    </div>
</div>



