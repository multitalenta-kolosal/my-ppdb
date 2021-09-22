<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order')->nullable()->default(999);
            $table->string('name');
            $table->text('description');
            $table->integer('tenor');
            $table->double('done_payment_fixed')->nullable()->default(0); 
            $table->double('done_payment_rate')->nullable()->default(0); 
            $table->double('interest')->nullable()->default(0);    
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
        Schema::dropIfExists('installments');
    }
}
