<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldsFromRegistrantStages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registrant_stages', function (Blueprint $table) {
            $table->dropColumn('delay_payment_pass');
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
            $table->boolean('delay_payment_pass')->nullable()->default(0);
        });
    }
}
