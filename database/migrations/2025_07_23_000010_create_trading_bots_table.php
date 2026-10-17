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
        Schema::create('trading_bots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('bot_type')->default('forex'); // forex, crypto, stocks, commodities
            $table->text('description');
            $table->string('image')->nullable();
            $table->decimal('min_investment', 15, 2)->default(100.00);
            $table->decimal('max_investment', 15, 2)->default(10000.00);
            $table->decimal('daily_profit_min', 5, 2)->default(0.5); // minimum daily profit %
            $table->decimal('daily_profit_max', 5, 2)->default(3.0); // maximum daily profit %
            $table->integer('success_rate')->default(85); // success rate percentage
            $table->integer('duration_days')->default(30); // bot duration in days
            $table->decimal('total_earned', 15, 2)->default(0); // total profits generated
            $table->integer('total_users')->default(0); // total users using this bot
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active');
            $table->json('trading_pairs')->nullable(); // supported trading pairs
            $table->json('risk_settings')->nullable(); // risk management settings
            $table->json('strategy_details')->nullable(); // trading strategy information
            $table->timestamp('last_trade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trading_bots');
    }
};
