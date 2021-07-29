<?php

namespace Modules\Message\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Message\Entities\Message;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon as Carbon;

class MessageDatabaseSeeder extends Seeder
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
                'code'              => 'register-message',
                'message'           => 'Halooo $name kamu sudah terdaftar di $unit Warga Surakarta!',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'code'              => 'requirements-message',
                'message'           => 'halo $name kamu sudah melengkapi persyaratan di $unit warga',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'code'              => 'test-message',
                'message'           => 'halo $name kamu sudah lulus tes di $unit warga',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'code'              => 'accepted-message',
                'message'           => 'halo $name kamu sudah diterima di $unit warga',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ];

        foreach ($messages as $message_data) {
            $message = Message::create($message_data);
        }

        Schema::enableForeignKeyConstraints();
    }
}
