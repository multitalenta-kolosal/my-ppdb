<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Message\Database\Seeders\MessageDatabaseSeeder;
use Modules\Core\Database\Seeders\CoreDatabaseSeeder;
use Modules\Finance\Database\Seeders\FinanceDatabaseSeeder;

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
        $this->call(CoreDatabaseSeeder::class);
        $this->call(FinanceDatabaseSeeder::class);

        Schema::enableForeignKeyConstraints();
    }
}
