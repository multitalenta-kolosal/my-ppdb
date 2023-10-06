<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNextPaymentToRegistrants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registrants', function (Blueprint $table) {
            $table->double('scheme_amount_next')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registrants', function (Blueprint $table) {
            $table->dropColumn('scheme_amount_next');
        });
    }
}
