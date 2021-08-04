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
        $messages = [
            [
                'period_name'              => Carbon::now()->year."/".Carbon::now()->year+1,
                'year_start'               => Carbon::now()->year,
                'year_end'                 => Carbon::now()->year+1,
                'active_state'             => 1,
            ]
        ];

        foreach ($messages as $message_data) {
            $message = Message::create($message_data);
        }

        Schema::enableForeignKeyConstraints();
    }
}
