<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalLineToTiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tiers', function (Blueprint $table) { 
            $table->text('additional_lines_payment')->nullable()->default(NULL);
            $table->text('additional_lines_test')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tiers', function (Blueprint $table) {
            $table->dropColumn('additional_lines_payment');
            $table->dropColumn('additional_lines_test');
        });
    }
}
