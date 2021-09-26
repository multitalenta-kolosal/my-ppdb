<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUpdatedDateToRegistrantStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registrant_stages', function (Blueprint $table) {
            $table->datetime('va_pass_checked_date')->nullable()->default(NULL);
            $table->datetime('entrance_fee_pass_checked_date')->nullable()->default(NULL);
            $table->datetime('requirements_pass_checked_date')->nullable()->default(NULL);
            $table->datetime('test_pass_checked_date')->nullable()->default(NULL);
            $table->datetime('installment_id_checked_date')->nullable()->default(NULL);
            $table->datetime('accepted_pass_checked_date')->nullable()->default(NULL);
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
            $table->dropColumn('va_pass_checked_date');
            $table->dropColumn('entrance_fee_pass_checked_date');
            $table->dropColumn('requirements_pass_checked_date');
            $table->dropColumn('test_pass_checked_date');
            $table->dropColumn('installment_id_checked_date');
            $table->dropColumn('accepted_pass_checked_date');
        });
    }
}
