<?php
namespace Database\Seeders\Auth;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Create Roles
        $super_admin = Role::firstOrCreate(['name' => 'super admin']);
        $admin = Role::firstOrCreate(['name' => 'administrator']);
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $executive = Role::firstOrCreate(['name' => 'executive']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Create Permissions
        Permission::firstOrCreate(['name' => 'view_backend']);
        Permission::firstOrCreate(['name' => 'edit_settings']);
        Permission::firstOrCreate(['name' => 'view_logs']);
        Permission::firstOrCreate(['name' => 'inter_unit']);
        Permission::firstOrCreate(['name' => 'add_va']);

        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms]);
        }

        \Artisan::call('auth:permission', [
            'name' => 'posts',
        ]);
        echo "\n _Posts_ Permissions Created.";

        \Artisan::call('auth:permission', [
            'name' => 'categories',
        ]);
        echo "\n _Categories_ Permissions Created.";

        \Artisan::call('auth:permission', [
            'name' => 'tags',
        ]);
        echo "\n _Tags_ Permissions Created.";

        \Artisan::call('auth:permission', [
            'name' => 'comments',
        ]);
        echo "\n _Comments_ Permissions Created.";

        \Artisan::call('auth:permission', [
            'name' => 'registrants',
        ]);
        echo "\n _Registrants_ Permissions Created.";

        \Artisan::call('auth:permission', [
            'name' => 'units',
        ]);
        echo "\n _Units_ Permissions Created.";

        \Artisan::call('auth:permission', [
            'name' => 'periods',
        ]);

        \Artisan::call('auth:permission', [
            'name' => 'registrantstages',
        ]);

        \Artisan::call('auth:permission', [
            'name' => 'messages',
        ]);

        \Artisan::call('auth:permission', [
            'name' => 'registrantmessages',
        ]);

        \Artisan::call('auth:permission', [
            'name' => 'paths',
        ]);

        echo "\n _Periods_ Permissions Created.";
        
        echo "\n\n";

        // Assign Permissions to Roles
        $admin->givePermissionTo(Permission::all());
        $manager->givePermissionTo('view_backend');
        $executive->givePermissionTo('view_backend');

        Schema::enableForeignKeyConstraints();
    }
}
