<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrantStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrant_stages', function (Blueprint $table) {

            $table->bigIncrements('id')->unsigned();            
            $table->string('registrant_id')->nullable();
            $table->integer('status_id')->nullable()->default(0);
            $table->boolean('va_pass')->nullable()->default(0);
            $table->boolean('entrance_fee_pass')->nullable()->default(0);            
            $table->boolean('requirements_pass')->nullable()->default(0);            
            $table->boolean('test_pass')->nullable()->default(0);            
            $table->boolean('dpp_pass')->nullable()->default(0);           
            $table->boolean('dp_pass')->nullable()->default(0);
            $table->boolean('spp_pass')->nullable()->default(0);
            $table->boolean('accepted_pass')->nullable()->default(0);
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
        Schema::dropIfExists('registrant_stages');
    }
}
