<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrants', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('registrant_id')->nullable()->default(NULL);
            $table->string('va_number')->nullable()->default(NULL);
            $table->string('name')->nullable()->default(NULL);
            $table->string('type')->nullable()->default(NULL);
            $table->boolean('internal')->nullable()->default(0);
            $table->string('year')->nullable()->default(NULL);
            $table->string('phone')->nullable()->default(NULL);
            $table->string('email')->nullable()->default(NULL);
            $table->string('unit')->nullable()->default(NULL);
            $table->string('former_school')->nullable()->default(NULL);
            $table->string('status')->nullable()->default(NULL);
            $table->timestamps();
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
        Schema::dropIfExists('registrants');
    }
}
