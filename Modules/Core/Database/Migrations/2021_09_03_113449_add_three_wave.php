<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThreeWave extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('periods', function (Blueprint $table) {
            $table->date('wave_1')->nullable();
            $table->date('wave_2')->nullable();
            $table->date('wave_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('periods', function (Blueprint $table) {
            $table->dropColumn('wave_1');
            $table->dropColumn('wave_2');
            $table->dropColumn('wave_3');
        });
    }
}
