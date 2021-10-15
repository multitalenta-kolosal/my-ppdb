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
                        <strong class="h5">Rp. {{number_format($$module_name_singular->data->verified_registrants->count() * setting('reward_referee'), 2, ',', '.')}}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <h4 class="text-primary">Pendaftar dari Referee</h4>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">ID Pendaftaran</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Verified</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($$module_name_singular->data->registrants as $registrant)
                        <tr>
                            <td>
                                {{$registrant->name}}
                            </td>
                            <td>
                                {{$registrant->registrant_id}}
                            </td>
                            <td>
                                {{$registrant->unit->name}}
                            </td>
                            <td>
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
