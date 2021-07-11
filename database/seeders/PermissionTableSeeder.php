<?php
namespace Database\Seeders;

use Database\Seeders\Auth\PermissionRoleTableSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

/**
 * Class PermissionTableSeeder.
 */
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $this->call(PermissionRoleTableSeeder::class);

        Schema::enableForeignKeyConstraints();
    }
}
