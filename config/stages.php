<?php

return [
    'special-status' => [
        [
            'title'             => 'Ditolak',
            'pass-title'        => 'Ditolak',
            'tracker_action'    => 'Sayang sekali kamu tidak diterima di {{$registrant->data->unit->name}} Warga Surakarta',
            'tracker_content'   => 'Tetap Semangat dalam meraih mimpimu',
            'status_id'         => '-1',
            'validation'        => '',
            'message_tracker'   => 'not_pass_message_sent',
        ],
    ],
    'progress' => [
        [
            'title'             => 'Pendaftaran',
            'pass-title'        => 'Mendaftar',
            'tracker_action'    => 'PENDAFTARAN BERHASIL',
            'tracker_content'   => 'Silakan melakukan tahap berikutnya yaitu pembayaran biaya pendaftaran dan melengkapi berkas persyaratan, yang kemudian di upload di link yang dikirim melalui email/WA.',
            'status_id'         => '0',
            'validation'        => 'registrant_id',
            'message_tracker'   => 'register_pass_message_sent',
        ],
        [
            'title'             => 'Mendapatkan Virtual Account',
            'pass-title'        => 'VA Dibuat',
            'tracker_action'    => 'PENDAFTARAN BERHASIL',
            'tracker_content'   => 'Silakan melakukan tahap berikutnya yaitu pembayaran biaya pendaftaran dan melengkapi berkas persyaratan, yang kemudian di upload di link yang dikirim melalui email/WA.',
            'status_id'         => '1',
            'validation'        => 'va_pass',
            'message_tracker'   => null,
        ],
        [
            'title'             => 'Pembayaran Registrasi',
            'pass-title'        => 'Pendaftaran Lunas',
            'tracker_action'    => 'PEMBAYARAN PENDAFTARAN DIKONFIRMASI',
            'tracker_content'   => '',
            'status_id'         => '2',
            'validation'        => 'entrance_fee_pass',
            'message_tracker'   => null,
        ],
        [
            'title'             => 'Pengumpulan Berkas',
            'pass-title'        => 'Berkas Diterima',
            'tracker_action'    => 'PERSYARATAN SUDAH LENGKAP',
            'tracker_content'   => 'Silakan menunggu proses pemberian informasi lanjutan dari Sekolah melalui Whatsapp/Email',
            'status_id'         => '3',
            'validation'        => 'requirements_pass',
            'message_tracker'   => 'requirements_pass_message_sent',
        ],
        [
            'title'             => 'Pengumuman Status Penerimaan',
            'pass-title'        => 'Lulus Tes',
            'tracker_action'    => 'SELAMAT KAMU SUDAH DITERIMA!',
            'tracker_content'   => 'Setelah ini, silakan melakukan pembayaran biaya pendidikan berikut ini ke Virtual Account kamu diatas.',
            'status_id'         => '4',
            'validation'        => 'test_pass',
            'message_tracker'   => 'test_pass_message_sent',
        ],
        [
            'title'             => 'Pemilihan Skema Pembayaran Biaya Pendidikan',
            'pass-title'        => 'Angsuran Dipilih',
            'tracker_action'    => 'SELAMAT KAMU SUDAH DITERIMA!',
            'tracker_content'   => 'Setelah ini, silakan melakukan pembayaran biaya pendidikan berikut ini ke Virtual Account kamu diatas.',
            'status_id'         => '5',
            'validation'        => 'installment_id',
            'message_tracker'   => null,
        ],
        [
            'title'             => 'Penerimaan Pembayaran',
            'pass-title'        => 'Penerimaan Pembayaran',
            'tracker_action'    => 'TERIMA KASIH!',
            'tracker_content'   => 'Pembayaran kamu sudah kami terima',
            'status_id'         => '6',
            'validation'        => 'accepted_pass',
            'message_tracker'   => null,
        ],
    ],
    'payment'   =>[
        [
            'title'             => 'Pembayaran DPP',
            'status_id'         => null,
            'validation'        => 'dpp_pass',
            'message_tracker'   => null,
        ], 
        [
            'title'             => 'Pembayaran DP',
            'status_id'         => null,
            'validation'        => 'dp_pass',
            'message_tracker'   => null,
        ], 
        [
            'title'             => 'Pembayaran SPP',
            'status_id'         => null,
            'validation'        => 'spp_pass',
            'message_tracker'   => null,
        ],
    ]
    
];

?>