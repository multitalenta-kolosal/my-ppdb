<head>
    <style>
        @page {
            size: A4;
        }
        .page-break {
            page-break-before: always;
        }

        /* .container {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto; }
        @media (min-width: 576px) {
            .container {
            max-width: 540px; } }
        @media (min-width: 768px) {
            .container {
            max-width: 720px; } }
        @media (min-width: 992px) {
            .container {
            max-width: 960px; } }
        @media (min-width: 1200px) {
            .container {
            max-width: 1140px; } }

        .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px; }

        .col-3 {
        flex: 0 0 25%;
        max-width: 25%; }

        .col-9 {
        flex: 0 0 75%;
        max-width: 75%; }

        .justify-content-center {
  justify-content: center !important; }
.text-right {
  text-align: right !important; } */
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>
<body style=" font-family: TimesNewRoman;">
    <div class="page container">
        <div class="row justify-content-center">
            <h3>BUKTI PENDAFTARAN</h3>
        </div>
        <div class="row justify-content-center">
            <h3>PENERIMAAN PESERTA DIDIK BARU</h3>
        </div>
        <div class="row justify-content-center">
            <h3>YAYASAN PENDIDIKAN WARGA</h3>
        </div>
        <div class="row justify-content-center">
            <h3>{{$registrant->unit->name}}</h3>
        </div>
        <div class="row justify-content-center">
            <h3>Tahun Ajaran {{$registrant->period->period_name}}</h3>
        </div>

        <br>
        <div class="row">
            <div class="col-3">ID Pendaftar</div><div class="col-9">: {{$registrant->registrant_id}}</div>
        </div>
        <div class="row">
            <div class="col-3">Nomor Virtual Account</div><div class="col-9">: {{$registrant->va_number}}</div>
        </div>
        <div class="row">
            <div class="col-3">Nama</div><div class="col-9">: {{$registrant->name}}</div>
        </div>
        <div class="row">
            <div class="col-3">Jalur Pendaftaran</div><div class="col-9">: {{$registrant->path->name}}</div>
        </div>
        <div class="row">
            <div class="col-3">Kelas / Jurusan</div><div class="col-9">: {{$registrant->tier->tier_name}}</div>
        </div>
        <div class="row">
            <div class="col-3">No. Telp Ortu</div><div class="col-9">: {{$registrant->phone}}</div>
        </div>
        <div class="row">
            <div class="col-3">No. Telp Anak</div><div class="col-9">: {{$registrant->phone2}}</div>
        </div>
        <div class="row">
            <div class="col-3">Email Ortu</div><div class="col-9">: {{$registrant->email}}</div>
        </div>
        <div class="row">
            <div class="col-3">Email Anak</div><div class="col-9">: {{$registrant->email2}}</div>
        </div>
        <div class="row">
            <div class="col-3">Sekolah Asal</div><div class="col-9">: {{$registrant->former_school}}</div>
        </div>
        <div class="row">
            <div class="col-3">Skema SPM</div><div class="col-9">: {{$registrant->scheme_string}}</div>
        </div>
        <div class="row">
            <div class="col-3">Info dari</div><div class="col-9">: {{$registrant->info}}</div>
        </div>
        <br><br>
        <p>
        Selamat, anda telah dinyatakan terregistrasi melakukan pendaftaram pada tanggal {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $registrant->created_at)->format('d/m/Y')}}  di Unit {{$registrant->unit->name}} dengan jalur {{$registrant->path->name}}. 
        </p>
        <p>
        Untuk pembayaran uang pendaftaran, menggunakan nomor Virtual Account {{$registrant->va_number}} dari Bank Mandiri, dapat dilakukan melalui semua bank, dengan cara terlampir. 
        </p>
        <p>
        Anda dapat melakukan login ke : https://ppdb.warga.sch.id/cekstatus dengan ID Pendaftar : {{$registrant->registrant_id}} dan Nomor Orang Tua : {{$registrant->phone}} untuk melihat status dan keterangan tahap pendaftaran. 
        </p>
        <p>
        Jika ada pertanyaan dan memerlukan informasi seputar Pendaftaran Peserta Didik Baru Unit {{$registrant->unit->name}} silahkan dapat menghubungi nomor WA ({{$registrant->unit->contact_number}}) atau Nomor Admin Yayasan Pendidikan Warga Whatsapp (0817-324-700) 
        </p>

        <div class="text-right">
           Surakarta, {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $registrant->created_at)->format('d/m/Y')}} 
        </div>
        <br>
        <div class="text-right">
            Panitia Pendaftaran
        </div>
    </div>
    <div class="page page-break container">
        <img src="/img/keterangan-transfer.jpeg" alt="Attachment">

    </div> 
    <script>
        // Add a script to trigger the print dialog after a short delay (e.g., 1 second)
        window.setTimeout(function() {
            window.print();
        }, 1000); // 1000 milliseconds = 1 second
    </script>
</body>