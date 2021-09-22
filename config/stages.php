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
            'tracker_action'    => 'Menunggu Pembayaran Pendaftaran',
            'tracker_content'   => 'Silakan Mengikuti Tata Pembayaran yang Ada.',
            'status_id'         => '0',
            'validation'        => 'va_pass',
            'message_tracker'   => 'register_pass_message_sent',
        ],
        [
            'title'             => 'Virtual Account',
            'pass-title'        => 'VA Dibuat',
            'tracker_action'    => 'Menunggu Pembayaran Pendaftaran',
            'tracker_content'   => 'Silakan Mengikuti Tata Pembayaran yang Ada.',
            'status_id'         => '1',
            'validation'        => 'va_pass',
            'message_tracker'   => null,
        ],
        [
            'title'             => 'Pembayaran Registrasi',
            'pass-title'        => 'Pendaftaran Lunas',
            'tracker_action'    => 'Menunggu Pengumpulan Berkas',
            'tracker_content'   => '',
            'status_id'         => '2',
            'validation'        => 'entrance_fee_pass',
            'message_tracker'   => null,
        ],
        [
            'title'             => 'Pengumpulan Berkas',
            'pass-title'        => 'Berkas Diterima',
            'tracker_action'    => 'Mengikuti Tes Masuk',
            'tracker_content'   => '',
            'status_id'         => '3',
            'validation'        => 'requirements_pass',
            'message_tracker'   => 'requirements_pass_message_sent',
        ],
        [
            'title'             => 'Status Kelulusan Tes',
            'pass-title'        => 'Lulus Tes',
            'tracker_action'    => 'Selamat, Kamu dinyatakan lulus Tes!',
            'tracker_content'   => 'Silakan menunggu pesan masuk, Jika sudah, silakan ikuti instruksi yang ada untuk melanjutkan',
            'status_id'         => '4',
            'validation'        => 'test_pass',
            'message_tracker'   => 'test_pass_message_sent',
        ],
        [
            'title'             => 'Angsuran Biaya Pendidikan',
            'pass-title'        => 'Angsuran Dipilih',
            'tracker_action'    => 'Pembayaran sedang Dikonfirmasi',
            'tracker_content'   => 'Silakan Menunggu Konfirmasi dari Admin Sekolah',
            'status_id'         => '5',
            'validation'        => '',
            'message_tracker'   => null,
        ],
        [
            'title'             => 'Keputusan Penerimaan',
            'pass-title'        => 'Diterima',
            'tracker_action'    => 'Selamat!',
            'tracker_content'   => 'Anda Sudah diterima sebagai peserta didik!',
            'status_id'         => '6',
            'validation'        => 'accepted_pass',
            'message_tracker'   => 'accepted_pass_message_sent',
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