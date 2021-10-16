    <div class="col-12 col-sm-8">
        <hr>
        <h4 class="text-primary">Ringkasan Referal</h4>
        <hr>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">Total Referal</th>
                    <th scope="col">Total Terverifikasi</th>
                    <th scope="col">Reward Referee</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong class="text-danger">{{$$module_name_singular->data->registrants->count()}}</strong> CPDB
                    </td>
                    <td>
                        <strong class="text-danger">{{$$module_name_singular->data->verified_registrants->count()}}</strong> CPDB
                    </td>
                    <td>
                        <strong class="h5">Rp. {{number_format($$module_name_singular->data->count_reward(), 2, ',', '.')}}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <h4 class="text-primary">Pendaftar dari Referee</h4>
        <div class="table-responsive p-2">
            <table class="table table-hover table-bordered" >
                <thead>
                    <tr >
                        <th scope="col" style="border-color:black;" >Nama</th>
                        <th scope="col" style="border-color:black;" >ID Pendaftaran</th>
                        <th scope="col" style="border-color:black;" >Unit</th>
                        <th scope="col" style="border-color:black;" >Reward</th>
                        <th scope="col" style="border-color:black;" >Verified</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($$module_name_singular->data->registrants as $registrant)
                        <tr >
                            <td style="border-color:black;" >
                                {{$registrant->name}}
                            </td>
                            <td style="border-color:black;" >
                                {{$registrant->registrant_id}}
                            </td>
                            <td style="border-color:black;" >
                                {{$registrant->unit->name}}
                            </td >
                            <td style="border-color:black;" >
                                @if($registrant->unit->referal_reward)
                                    Rp. {{number_format($registrant->unit->referal_reward, 2, ',', '.')}}
                                @else
                                    <span class="text-danger">*Nilai Reward belum ditentukan</span>
                                @endif
                            </td>
                            <td style="border-color:black;" >
                                @if($registrant->registrant_stage->accepted_pass)
                                    <i class="far fa-lg fa-check-circle text-success"></i>
                                @else
                                    <i class="fas fa-lg fa-spinner fa-pulse text-primary"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> 
        </div>
    </div>
