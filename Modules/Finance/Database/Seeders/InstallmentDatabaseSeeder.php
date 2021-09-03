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
            ]
        ];

        foreach ($installments as $installment_data) {
            $installment = Installment::create($installment_data);
        }

        Schema::enableForeignKeyConstraints();
    }
}
