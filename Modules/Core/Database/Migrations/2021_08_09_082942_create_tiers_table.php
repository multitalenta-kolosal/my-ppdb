<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('unit_id')->nullable();
            $table->string('tier_name')->nullable()->default(NULL);
            $table->string('tier_code')->nullable()->default(NULL);
            $table->string('contact_number')->nullable()->default(NULL);
            $table->string('contact_email')->nullable()->default(NULL);
            $table->string('order')->nullable()->default(NULL);
            $table->text('tier_requirements')->nullable()->default(NULL);
            $table->string('entrance_test_url')->nullable()->default(NULL);
            $table->string('dpp')->nullable()->default(NULL);
            $table->string('dp')->nullable()->default(NULL);
            $table->string('spp')->nullable()->default(NULL);
            $table->timestamps();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiers');
    }
}
