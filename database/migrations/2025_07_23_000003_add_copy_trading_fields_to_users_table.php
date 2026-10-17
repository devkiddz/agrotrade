<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add copy trading fields
            // $table->string('copy')->nullable()->after('trade_mode'); // Current copied trader name
            // $table->integer('copy_plan')->nullable()->after('copy'); // Current copy trading plan ID
            $table->integer('trade')->default(0)->after('copy_plan'); // Is user currently trading (0 or 1)
            // $table->string('sendroiemail')->default('No')->after('trade'); // Send ROI emails setting
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['copy', 'copy_plan', 'trade', 'sendroiemail']);
        });
    }
};
