<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Message\Database\Seeders\MessageDatabaseSeeder;
use Modules\Core\Database\Seeders\PeriodDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->call(AuthTableSeeder::class);
        $this->call(MessageDatabaseSeeder::class);

        Schema::enableForeignKeyConstraints();
    }
}
