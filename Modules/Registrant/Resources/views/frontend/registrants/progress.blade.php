
<?php
    $stages   =  config('stages.progress');
    $now =  Illuminate\Support\Arr::get(config('stages.progress'), $registrant->data->registrant_stage->status_id);
?>

<div>
    <h2 class="display-3 mb-3 text-center">
        Progress Calon Peserta
    </h2>
    <div class="row py-1 my-3 text-center justify-content-center align-middle">
        <div class="col-sm-6 col-md-6">
            <h4 class="text-primary">{{$registrant->data->name ?? 'DATA NOT FOUND'}}</h4>
        </div>
    </div>
    <div class="row py-1 my-3 shadow border rounded text-center">
        <div class="col-4 align-middle">
            <strong>Jalur: </strong><br>{{$registrant->data->path->name ?? 'Jalur Tidak Ditemukan'}}
        </div>
        <div class="col-4 align-middle">
            <strong>ID: </strong><br>{{$registrant->data->registrant_id ?? 'DATA NOT FOUND'}}
        </div>
        <div class="col-4 align-middle">
            <strong>Tgl. Daftar: </strong><br>{{Carbon\Carbon::parse($registrant->data->created_at)->format('d-m-Y, H:i:s') ?? 'DATA NOT FOUND'}}
        </div>
    </div>
    <!-- progress timeline    -->
    <ul class="progress-tracker progress-tracker mb-0 ">
        @foreach($stages as $stage)
        <?php
            $validation = $stage['validation'];
        ?>
        <li id="progress_{{$stage['status_id']}}" class="progress-step {{ ($stage['status_id'] == $registrant->data->registrant_stage->status_id) ? 'is-active' : ($registrant->data->registrant_stage->$validation ? 'is-complete' : '') }}">
            <div class="progress-marker"></div>
            @if($stage['status_id'] == $registrant->data->registrant_stage->status_id)
                <div class="progress-text progress-text--dotted progress-text--dotted-3">
                </div>
            @endif
        </li>
        @endforeach
    </ul>
    <!-- END of progress timeline    -->
</div>
<div class="card shadow bg-white border-light p-1 text-center">
    <div class="card-body col-auto py-3 p-lg-3">      
        <div class="row py-2 justify-content-center">
            <div class="col-10 shadow-sm border rounded align-middle text-info">
                <h4 class="display-4 py-2 text-success">
                    {{$now['tracker_action']}}
                </h4>
            </div>
        </div>     
        <div class="row py-2">
            <div class="col py-2 border-light">
                <h5 class="display-5 text-info">
                    {{$now['tracker_content']}}
                </h5>
                @if( ($now['status_id'] == 0 || $now['status_id'] == 1) && $registrant->data->unit->registration_veriform_link)
                    <div id="extra-content">
                        Jika kamu memiliki akun <span class="text-danger">Gmail</span> (Google), Kamu dapat melakukan verifikasi pembayaran dan pengumpulan berkas untuk <strong> {{$registrant->data->unit->name}} Warga Surakarta </strong> secara <strong class="text-warning">ONLINE</strong> melalui Google form 
                        dengan cara klik tombol di bawah ini
                        <div class="row my-2 justify-content-center">
                            <a href="{{$registrant->data->unit->registration_veriform_link}}" class="btn btn-outline-primary">Form Verifikasi</a>
                        </div>
                    </div>
                @endif
                @if($now['status_id'] == 5)
                    <div id="extra-content">
                        Cicilan yang sudah dipilih adalah cicilan <span class="text-primary"><strong>{{$registrant->data->registrant_stage->installment->name}}</strong></span>
                    </div>
                @endif
                @if($now['message_tracker'])
                    <div class="alert alert-warning my-1 text-dark" role="alert">
                       <strong>PERHATIAN!!</strong> Kamu seharusnya sudah mendapatkan pesan, Silakan cek status <strong>Pesan {{$now['title']}} </strong> di bawah ini untuk memastikan pesan terkirim.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card shadow bg-white border-light mt-2 text-center">
    <h4 class="display-5 my-2 text-center">
        Status Pesan Terkirim
    </h5>
    <div class="card-body col-auto py-3 p-lg-3">    
        <div class="row border py-1">
            <div class="col border py-1 align-middle text-center">
                Pesan Pendaftaran
            </div>
            <div class="col border py-1 align-middle text-center">
                @if($registrant->data->registrant_message->register_pass_message_sent == 1)
                    <span class="badge bg-success text-white">Sukses</span>
                @elseif($registrant->data->registrant_message->register_pass_message_sent == -1)
                    <span class="badge bg-danger">Gagal</span>
                @else
                    <span class="badge bg-gray">Belum Dikirim</span>
                @endif
            </div>
        </div>
        
        @if($registrant->data->registrant_message->register_pass_message_sent == -1)
            <div class="alert alert-danger my-1" role="alert">
                Pesan ini tidak terkirim! Silakan hubungi admin unit {{$registrant->data->unit->name}} (WA/telp) di {{$registrant->data->unit->contact_number}}
            </div>
        @endif

        <div class="row border py-1">
            <div class="col border py-1 align-middle text-center">
                Pesan Pengumpulan Berkas
            </div>
            <div class="col border py-1 align-middle text-center">
                @if($registrant->data->registrant_message->requirements_pass_message_sent == 1)
                    <span class="badge bg-success text-white">Sukses</span>
                @elseif($registrant->data->registrant_message->requirements_pass_message_sent == -1)
                    <span class="badge bg-danger">Gagal</span>
                @else
                    <span class="badge bg-gray">Belum Dikirim</span>
                @endif
            </div>
        </div>

        @if($registrant->data->registrant_message->requirements_pass_message_sent == -1)
            <div class="alert alert-danger my-1" role="alert">
                Pesan ini tidak terkirim! Silakan hubungi admin unit (WA/telp) di {{$registrant->data->unit->phone}}
            </div>
        @endif

        <div class="row border py-1">
            <div class="col border py-1 align-middle text-center">
                Pesan Status Kelulusan Tes
            </div>
            <div class="col border py-1 align-middle text-center">
                @if($registrant->data->registrant_message->test_pass_message_sent == 1)
                    <span class="badge bg-success text-white">Sukses</span>
                @elseif($registrant->data->registrant_message->test_pass_message_sent == -1)
                    <span class="badge bg-danger">Gagal</span>
                @else
                    <span class="badge bg-gray">Belum Dikirim</span>
                @endif
            </div>
        </div>
        
        @if($registrant->data->registrant_message->test_pass_message_sent == -1)
            <div class="alert alert-danger my-1" role="alert">
                Pesan ini tidak terkirim! Silakan hubungi admin unit (WA/telp) di {{$registrant->data->unit->phone}}
            </div>
        @endif

        <div class="row border py-1">
            <div class="col border py-1 align-middle text-center">
                Pesan Keputusan Penerimaan
            </div>
            <div class="col border py-1 align-middle text-center">
                @if($registrant->data->registrant_message->accepted_pass_message_sent == 1)
                    <span class="badge bg-success text-white">Sukses</span>
                @elseif($registrant->data->registrant_message->accepted_pass_message_sent == -1)
                    <span class="badge bg-danger">Gagal</span>
                @else
                    <span class="badge bg-gray">Belum Dikirim</span>
                @endif
            </div>
        </div>
        
        @if($registrant->data->registrant_message->accepted_pass_message_sent == -1)
            <div class="alert alert-danger my-1" role="alert">
                Pesan ini tidak terkirim! Silakan hubungi admin unit (WA/telp) di {{$registrant->data->unit->phone}}
            </div>
        @endif

    </div>
</div>

<div class="card shadow bg-white border-light mt-2 text-center">
    <h4 class="display-5 my-2 text-center">
        Riwayat Proses Penerimaan
    </h5>
    <div class="card-body col-auto py-3 p-lg-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Proses</th>
                    <th scope="col">Diverifikasi Pada</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stages as $stage)
                    @if ($loop->first) @continue @endif
                    <?php
                        $validation = $stage['validation'];
                        $validation_date = $validation.'_checked_date';
                        if($registrant->data->registrant_stage->$validation_date && $registrant->data->registrant_stage->$validation){
                            $carbon_validation_date = \Carbon\Carbon::parse($registrant->data->registrant_stage->$validation_date);
                            $formatted_validation_date = $carbon_validation_date->format('d M Y, H:i');
                        }else{
                            $formatted_validation_date = '--';
                        }
                    ?>
                    <tr>
                        <td>{{$stage['title']}}</td>
                        <td>
                            {{$formatted_validation_date}}
                            @if($registrant->data->registrant_stage->$validation)
                                <i class="far fa-check-circle text-success"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table> 

    </div>
</div>


