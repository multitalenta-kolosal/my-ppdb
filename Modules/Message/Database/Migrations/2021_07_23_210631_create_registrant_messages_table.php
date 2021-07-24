<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrantMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrant_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('registrant_id')->nullable();
            $table->boolean('register_pass_message_sent')->nullable()->default(0);
            $table->boolean('requirements_pass_message_sent')->nullable()->default(0);
            $table->boolean('test_pass_message_sent')->nullable()->default(0);
            $table->boolean('accepted_pass_message_sent')->nullable()->default(0);
            $table->timestamps();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrant_messages');
    }
}
