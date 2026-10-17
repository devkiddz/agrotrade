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
        Schema::table('user_copytradings', function (Blueprint $table) {
            // Add missing fields for profit tracking and management
            $table->timestamp('started_at')->nullable()->after('type'); // When copy trading started
            $table->timestamp('last_profit')->nullable()->after('started_at'); // Last profit calculation time
            $table->decimal('total_profit', 15, 2)->default(0)->after('last_profit'); // Total profits earned
            $table->decimal('current_balance', 15, 2)->default(0)->after('total_profit'); // Current balance
            $table->integer('total_trades')->default(0)->after('current_balance'); // Total trades copied
            $table->integer('winning_trades')->default(0)->after('total_trades'); // Winning trades
            $table->decimal('profit_percentage', 8, 2)->default(0)->after('winning_trades'); // Overall profit percentage
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_copytradings', function (Blueprint $table) {
            $table->dropColumn([
                'started_at',
                'last_profit',
                'total_profit',
                'current_balance',
                'total_trades',
                'winning_trades',
                'profit_percentage'
            ]);
        });
    }
};
