<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVeriformLinkToUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->string('register_form_link')->nullable();
            $table->string('registration_veriform_link')->nullable();
            $table->string('tuition_veriform_link')->nullable();
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
            $table->string('register_form_link')->nullable();
            $table->dropColumn('registration_veriform_link');
            $table->dropColumn('tuition_veriform_link');
        });
    }
}
