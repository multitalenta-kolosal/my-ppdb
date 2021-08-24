<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInstallmentIdToRegistrantStages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registrant_stages', function (Blueprint $table) {
            $table->integer('installment_id')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registrant_stages', function (Blueprint $table) {
            $table->integer('installment_id')->nullable()->default(NULL);
        });
    }
}
