
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
            <strong>Nomor: </strong><br>{{$registrant->data->registrant_id ?? 'DATA NOT FOUND'}}
        </div>
        <div class="col-4 align-middle">
            <strong>Tgl. Daftar: </strong><br>{{Carbon\Carbon::parse($registrant->data->created_at)->format('d M Y') ?? 'DATA NOT FOUND'}}
        </div>
    </div>
    <div class="row py-1 my-3 shadow border rounded text-center">
        <div class="col align-middle">
            <span class="display-4">Virtual Account:</span><strong class="display-4 text-danger"> {{$registrant->data->registrant_stage->va_pass ? $registrant->data->va_number : 'Sedang diproses...'}}</strong>
        </div>
    </div>
    <!-- progress timeline    -->
    <ul class="progress-tracker progress-tracker mb-0 ">
            <?php
                $last_status = 0;
            ?>

        @foreach($stages as $stage)
            <?php
                $validation = $stage['validation'];
                $skipped_status = [1,5];
            ?>

            @if(!in_array($stage['status_id'],$skipped_status))

                <li id="progress_{{$stage['status_id']}}" class="progress-step {{ ($stage['status_id'] == $registrant->data->registrant_stage->status_id) ? 'is-active' : ($registrant->data->registrant_stage->$validation ? 'is-complete' : '') }}">
                    <div class="progress-marker"></div>
                    @if($stage['status_id'] == $registrant->data->registrant_stage->status_id)
                        <div class="progress-text progress-text--dotted progress-text--dotted-3">
                        </div>
                        <?php
                            
                            $last_status=$stage['status_id'];
                        ?>
                    @elseif(in_array($now['status_id'],$skipped_status))
                        @if($stage['status_id'] == ($now['status_id']-1) )
                            <div class="progress-text progress-text--dotted progress-text--dotted-3">
                            </div>
                        @endif
                    @endif
                </li>
            @endif
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
                @if( ($now['status_id'] == 0 || $now['status_id'] == 1  || $now['status_id'] == 2) && $registrant->data->unit->registration_veriform_link)
                    <div id="extra-content">
                        Jika kamu memiliki akun <span class="text-danger">Gmail</span> (Google), Kamu dapat melakukan verifikasi pembayaran dan pengumpulan berkas untuk <strong> {{$registrant->data->unit->name}} Warga Surakarta </strong> secara <strong class="text-warning">ONLINE</strong> melalui Google form 
                        dengan cara klik tombol di bawah ini
                        <div class="row my-2 justify-content-center">
                            <a href="{{$registrant->data->unit->registration_veriform_link}}" class="btn btn-outline-primary">Form Verifikasi</a>
                        </div>
                    </div>
                @endif
                @if($now['status_id'] == 4 || $now['status_id'] == 5)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nama Biaya</th>
                            <th scope="col">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                DPP
                            </td>
                            <td>
                                <?php                                        
                                    if($registrant->data->unit->have_major && $registrant->data->tier->dpp){
                                        $value = $registrant->data->tier->dpp;
                                    }else{
                                        $value = $registrant->data->unit->dpp;
                                    }
                                ?>
                                Rp. {{number_format($value , 2, ',', '.')}}
                            </td>
                        </tr>
                            <td>
                                DP
                            </td>
                            <td>
                                <?php                                        
                                    if($registrant->data->unit->have_major && $registrant->data->tier->dp){
                                        $value = $registrant->data->tier->dp;
                                    }else{
                                        $value = $registrant->data->unit->dp;
                                    }
                                ?>
                                Rp. {{number_format($value , 2, ',', '.')}}
                            </td>
                        </tr>
                            <td>
                                SPP
                            </td>
                            <td>
                                <?php                                        
                                    if($registrant->data->unit->have_major && $registrant->data->tier->spp){
                                        $value = $registrant->data->tier->spp;
                                    }else{
                                        $value = $registrant->data->unit->spp;
                                    }
                                ?>
                                Rp. {{number_format($value , 2, ',', '.')}}
                            </td>
                        </tr>
                    </tbody>
                </table> 
                @endif
                @if($now['status_id'] == 6)
                    @if($registrant->data->registrant_stage->installment->tenor > 1) 
                        <div id="extra-content">
                            Skema pembayaran yang dipilih adalah dengan cara mengangsur biaya pendidikan dengan <span class="text-primary"><strong>{{$registrant->data->registrant_stage->installment->name}}</strong></span> pembayaran
                        </div>
                        <div id="extra-content">
                            Terima kasih, karena kamu sudah melakukan pembayaran tahap pertama
                        </div>
                    @else
                        <div id="extra-content">
                            Terima kasih, karena kamu sudah melakukan pelunasan DP, DPP dan SPP Bulan Juli 2022
                        </div>
                    @endif
                @endif
                    <hr>
                    <div id="extra-content">
                        Untuk Informasi lebih lanjut terkait proses penerimaan silakan hubungi: (WA/telp) <span class="text-danger"><strong>{{$registrant->data->unit->contact_number}}</strong></span>
                    </div>
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
                Pesan Pengumuman Penerimaan
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
<!-- 
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
        </div> -->
        
        @if($registrant->data->registrant_message->accepted_pass_message_sent == -1)
            <div class="alert alert-danger my-1" role="alert">
                Pesan ini tidak terkirim! Silakan hubungi admin unit (WA/telp) di {{$registrant->data->unit->phone}}
            </div>
        @endif

    </div>
</div>

<div class="card shadow bg-white border-light mt-2 text-center">
    <h4 class="display-5 my-2 text-center">
        Riwayat Proses Penerimaan Peserta Didik
    </h5>
    <div class="card-body col-auto py-3 p-lg-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Proses</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stages as $stage)
                    <!-- forhidereg -->
                    @if ($loop->first) @continue @endif
                    <!-- forhideva -->
                    @if ($stage['status_id'] == 1) @continue @endif 
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
                        <td>
                            {{$formatted_validation_date}}
                            @if($registrant->data->registrant_stage->$validation)
                                <i class="far fa-check-circle text-success"></i>
                            @endif
                        </td>
                        <td>{{$stage['title']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table> 

    </div>
</div>


