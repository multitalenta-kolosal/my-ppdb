<head>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

</head>
<body>
    @php
        $counter = 0;
    @endphp
    @foreach($referees as $referee) 
        @if($referee->verified_registrants()->count() > 0)
            <div class=container>
                <div class="col-12 col-sm-8">
                    <hr>
                    <h4 class="text-primary">Ringkasan Referal</h4>
                    <table class="table table-sm" style="width: 50%">
                        <tbody>
                            <tr>
                                <td>
                                    Nama 
                                </td>
                                <td>
                                    : {{$referee->name}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Email 
                                </td>
                                <td>
                                    : {{$referee->email}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Phone 
                                </td>
                                <td>
                                    : {{$referee->phone}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Bank 
                                </td>
                                <td>
                                    : {{$referee->bank_name}} 
                                    <br>
                                    {{$referee->bank_account}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Ref Code 
                                </td>
                                <td>
                                    : {{$referee->ref_code}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Total Terverifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong class="text-danger">{{$referee->verified_registrants->count()}}</strong> CPDB
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <h4 class="text-primary">Pendaftar</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">ID Pendaftaran</th>
                                <th scope="col">Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($referee->registrants as $registrant)
                                @if($registrant->registrant_stage->accepted_pass)
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
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table> 
                </div>
            </div>
            @php
                $counter ++;
            @endphp
        @endif
    @endforeach

    @if($counter == 0)
     Tidak ada referal yang terverifikasi
    @endif
</body>