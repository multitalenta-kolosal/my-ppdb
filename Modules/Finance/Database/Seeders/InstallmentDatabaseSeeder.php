<?php

namespace Modules\Finance\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Finance\Entities\Installment;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon as Carbon;

class InstallmentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        Schema::disableForeignKeyConstraints();

        $faker = \Faker\Factory::create();

        $installments = [
            [
                'name'                     => "Penuh",
                'order'                    => -1,
                'tenor'                    => 0,
                'description'              => "Pembayaran Penuh",
                'created_at'               => Carbon::now(),
                'updated_at'               => Carbon::now(),
            ],
            [
                'name'                     => "1 Bulan",
                'order'                    => 1,
                'tenor'                    => 1,
                'description'              => "Pembayaran 1 Bulan",
                'created_at'               => Carbon::now(),
                'updated_at'               => Carbon::now(),
            ],
            [
                'name'                     => "2 Bulan",
                'order'                    => 2,
                'tenor'                    => 2,
                'description'              => "Pembayaran 2 Bulan",
                'created_at'               => Carbon::now(),
                'updated_at'               => Carbon::now(),
            ],
            [
                'name'                     => "3 Bulan",
                'order'                    => 3,
                'tenor'                    => 3,
                'description'              => "Pembayaran 3 Bulan",
                'created_at'               => Carbon::now(),
                'updated_at'               => Carbon::now(),
            ],
            [
                'name'                     => "4 Bulan",
                'order'                    => 4,
                'tenor'                    => 4,
                'description'              => "Pembayaran 4 Bulan",
                'created_at'               => Carbon::now(),
                'updated_at'               => Carbon::now(),
            ],
            [
                'name'                     => "5 Bulan",
                'order'                    => 5,
                'tenor'                    => 5,
                'description'              => "Pembayaran 5 Bulan",
                'created_at'               => Carbon::now(),
                'updated_at'               => Carbon::now(),
            ],
            [
                'name'                     => "6 Bulan",
                'order'                    => 6,
                'tenor'                    => 6,
                'description'              => "Pembayaran 6 Bulan",
                'created_at'               => Carbon::now(),
                'updated_at'               => Carbon::now(),
            ],
            [
                'name'                     => "7 Bulan",
                'order'                    => 7,
                'tenor'                    => 7,
                'description'              => "Pembayaran 7 Bulan",
                'created_at'               => Carbon::now(),
                'updated_at'               => Carbon::now(),
            ],
            [
                'name'                     => "8 Bulan",
                'order'                    => 8,
                'tenor'                    => 8,
                'description'              => "Pembayaran 8 Bulan",
                'created_at'               => Carbon::now(),
                'updated_at'               => Carbon::now(),
            ],
            [
                'name'                     => "9 Bulan",
                'order'                    => 9,
                'tenor'                    => 9,
                'description'              => "Pembayaran 9 Bulan",
                'created_at'               => Carbon::now(),
                'updated_at'               => Carbon::now(),
            ],
            [
                'name'                     => "10 Bulan",
                'order'                    => 10,
                'tenor'                    => 10,
                'description'              => "Pembayaran 10 Bulan",
                'created_at'               => Carbon::now(),
                'updated_at'               => Carbon::now(),
            ],
        ];

        foreach ($installments as $installment_data) {
            $installment = Installment::create($installment_data);
        }

        Schema::enableForeignKeyConstraints();
    }
}
