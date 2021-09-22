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
            $table->dropColumn('dpp_pass');
            $table->dropColumn('dp_pass');
            $table->dropColumn('spp_pass');
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
            $table->boolean('dpp_pass')->nullable()->default(0);           
            $table->boolean('dp_pass')->nullable()->default(0);
            $table->boolean('spp_pass')->nullable()->default(0);
            $table->boolean('delay_payment_pass')->nullable()->default(0);
        });
    }
}
