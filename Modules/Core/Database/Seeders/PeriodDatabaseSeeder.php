<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Entities\Period;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon as Carbon;

class PeriodDatabaseSeeder extends Seeder
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

        // Add the master administrator, user id of 1
        $periods = [
            [
                'period_name'              => Carbon::now()->year."/".Carbon::now()->addYear()->year,
                'year_start'               => Carbon::now()->year,
                'year_end'                 => Carbon::now()->addYear()->year,
                'active_state'             => 1,
                'created_at'               => Carbon::now(),
                'updated_at'               => Carbon::now(),
            ]
        ];

        foreach ($periods as $period_data) {
            $period = Period::create($period_data);
        }

        Schema::enableForeignKeyConstraints();
    }
}
