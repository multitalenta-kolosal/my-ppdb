<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitPathFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_path_fees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('unit_id');
            $table->bigInteger('path_id');
            $table->double('dp')->nullable();
            $table->double('dpp')->nullable();
            $table->double('spp')->nullable();
            $table->double('school_fee')->nullable();
            $table->boolean('enabled')->default(0);
            $table->boolean('use_credit_scheme')->default(0);
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
        Schema::dropIfExists('unit_path_fees');
    }
}
