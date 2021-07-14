<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVerificationBaseFieldToUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->boolean('have_major')->nullable()->default(NULL);
            $table->double('dpp',191,2)->nullable()->default(NULL);
            $table->double('dp',191,2)->nullable()->default(NULL);
            $table->double('spp',191,2)->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn('have_major');
            $table->dropColumn('dpp',191,2);
            $table->dropColumn('dp',191,2);
            $table->dropColumn('spp',191,2);
        });
    }
}
