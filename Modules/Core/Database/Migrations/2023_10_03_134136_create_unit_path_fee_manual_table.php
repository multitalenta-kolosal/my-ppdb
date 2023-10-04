<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitPathFeeManualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_path_fee_manual', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('unit_id');
            $table->bigInteger('path_id');
            $table->bigInteger('tier_id')->nullable();
            $table->integer('tenor')->unsigned()->nullable();
            $table->integer('payment_number')->unsigned()->nullable();
            $table->double('spp')->nullable();
            $table->double('school_fee')->nullable();
            $table->timestamps();
            $table->softdeletes();
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
        Schema::dropIfExists('unit_path_fee_manual');
    }
}
