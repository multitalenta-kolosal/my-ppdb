<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVerificationBaseFieldToRegistrants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registrants', function (Blueprint $table) {
           $table->integer('unit_increment')->nullable()->default(NULL);
           $table->integer('progress_id')->nullable()->default(NULL);
           $table->integer('message_tracker_id')->nullable()->default(NULL);
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
            $table->dropColumn('unit_increment');
            $table->dropColumn('progress_id');
            $table->dropColumn('message_tracker_id');
        });
    }
}
