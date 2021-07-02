<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'        => ':attribute Harus diterima.',
    'active_url'      => ':attribute bukan URL yang valid.',
    'after'           => ':attribute harus tanggal sesudah tanggal :date.',
    'after_or_equal'  => ':attribute harus tanggal yang sama atau sesudah tanggal :date.',
    'alpha'           => ':attribute hanya boleh berisi huruf.',
    'alpha_dash'      => ':attribute hanya boleh berisi huruf, angka, strip dan underscores.',
    'alpha_num'       => ':attribute hanya boleh berisi huruf dan angka.',
    'array'           => ':attribute harus berbentuk array.',
    'before'          => ':attribute harus tanggal sebelum :date.',
    'before_or_equal' => ':attribute harus tanggal yang sama atau sebelum tanggal :date.',
    'between'         => [
        'numeric' => ':attribute harus diantara :min dan :max.',
        'file'    => ':attribute harus diantara :min dan :max kilobytes.',
        'string'  => ':attribute harus diantara :min dan :max karakter.',
        'array'   => ':attribute harus diantara :min dan :max.',
    ],
    'boolean'        => ':attribute hanya boleh true atau false.',
    'confirmed'      => ':attribute konfirmasi tidak cocok.',
    'date'           => ':attribute bukan tanggal yang valid.',
    'date_equals'    => ':attribute harus sama dengan tanggal :date.',
    'date_format'    => ':attribute tidak sama dengan format :format.',
    'different'      => ':attribute dan :other harus berbeda.',
    'digits'         => ':attribute harus :digits digit.',
    'digits_between' => ':attribute harus diantara :min dan :max digit.',
    'dimensions'     => ':attribute memiliki dimensi gambar yang tidak valid.',
    'distinct'       => ':attribute memiliki nilai yang terduplikat.',
    'email'          => ':attribute haruslah alamat email yang valid.',
    'ends_with'      => ':attribute harus diakhiri dengan :values.',
    'exists'         => ':attribute yang telah dipilih tidak valid.',
    'file'           => ':attribute harus sebuah file.',
    'filled'         => ':attribute harus memiliki nilai.',
    'gt'             => [
        'numeric' => ':attribute harus lebih dari :value.',
        'file'    => ':attribute harus lebih dari :value kilobyte.',
        'string'  => ':attribute harus lebih dari :value karakter.',
        'array'   => ':attribute harus lebih dari :value.',
    ],
    'gte' => [
        'numeric' => ':attribute harus lebih dari sama dengan :value.',
        'file'    => ':attribute harus lebih dari sama dengan :value kilobyte.',
        'string'  => ':attribute harus lebih dari sama dengan :value karakter.',
        'array'   => ':attribute harus memiliki :value item atau lebih.',
    ],
    'image'    => ':attribute harus sebuah gambar.',
    'in'       => ':attribute yang dipilih tidak valid.',
    'in_array' => ':attribute ini tidak ada di :other.',
    'integer'  => ':attribute harus sebuah integer (bilangan bulat).',
    'ip'       => ':attribute harus sebuah IP address yang valid.',
    'ipv4'     => ':attribute harus sebuah IPv4 address yang valid.',
    'ipv6'     => ':attribute harus sebuah IPv6 address yang valid.',
    'json'     => ':attribute harus sebuah JSON string yang valid.',
    'lt'       => [
        'numeric' => ':attribute harus kurang dari:value.',
        'file'    => ':attribute harus kurang dari :value kilobyte.',
        'string'  => ':attribute harus kurang dari :value karakter.',
        'array'   => ':attribute harus kurang dari :value.',
    ],
    'lte' => [
        'numeric' => ':attribute harus kurang dari sama dengan :value.',
        'file'    => ':attribute harus kurang dari sama dengan :value kilobyte.',
        'string'  => ':attribute harus kurang dari sama dengan :value karakter.',
        'array'   => ':attribute tidak boleh memiliki lebih dari :value buah.',
    ],
    'max' => [
        'numeric' => ':attribute tidak boleh lebih besar dari :max.',
        'file'    => ':attribute tidak boleh lebih besar dari :max kilobyte.',
        'string'  => ':attribute tidak boleh lebih besar dari :max karakter.',
        'array'   => ':attribute tidak boleh lebih banyak dari :max buah.',
    ],
    'mimes'     => ':attribute harus file dengan jenis: :values.',
    'mimetypes' => ':attribute harus file dengan jenis: :values.',
    'min'       => [
        'numeric' => ':attribute minimal harus :min.',
        'file'    => ':attribute minimal harus :min kilobyte.',
        'string'  => ':attribute minimal harus :min karakter.',
        'array'   => ':attribute minimal harus :min buah.',
    ],
    'not_in'               => ':attribute yang dipilih tidak valid.',
    'not_regex'            => 'format :attribute tidak valid.',
    'numeric'              => ':attribute harus berbentuk angka.',
    'password'             => 'Password salah.',
    'present'              => ':attribute ini harus ada.',
    'regex'                => 'format :attribute ini tidak valid.',
    'required'             => ':attribute ini dibutuhkan.',
    'required_if'          => ':attribute ini dibutuhkan ketika :other adalah :value.',
    'required_unless'      => ':attribute ini dibutuhkan kecuali jika :other ada di :values.',
    'required_with'        => ':attribute ini dibutuhkan ketika :values ada.',
    'required_with_all'    => ':attribute ini dibutuhkan ketika :values ada.',
    'required_without'     => ':attribute ini dibutuhkan ketika :values tidak ada.',
    'required_without_all' => ':attribute ini dibutuhkan ketika tidak ada :values.',
    'same'                 => ':attribute dan :other harus sama.',
    'size'                 => [
        'numeric' => ':attribute haruslah :size.',
        'file'    => ':attribute haruslah :size kilobyte.',
        'string'  => ':attribute haruslah :size karakter.',
        'array'   => ':attribute haruslah berisi :size buah.',
    ],
    'starts_with' => ':attribute harus dimulai dengan: :values.',
    'string'      => ':attribute harus sebuah string (kata).',
    'timezone'    => ':attribute harus sebuah zona waktu yang valid.',
    'unique'      => ':attribute ini sudah dipakai.',
    'uploaded'    => ':attribute gagal untuk upload.',
    'url'         => ':attribute format ini tidak valid.',
    'uuid'        => ':attribute bukanlah UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'pesan kustom',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
