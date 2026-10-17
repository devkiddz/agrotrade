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
        Schema::create('bot_trading_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_bot_investment_id');
            $table->string('trade_type'); // BUY, SELL
            $table->string('trading_pair'); // EUR/USD, BTC/USD, etc.
            $table->decimal('entry_price', 15, 8);
            $table->decimal('exit_price', 15, 8)->nullable();
            $table->decimal('amount', 15, 2);
            $table->decimal('profit_loss', 15, 2)->default(0);
            $table->decimal('profit_percentage', 8, 4)->default(0);
            $table->enum('result', ['pending', 'profit', 'loss'])->default('pending');
            $table->text('strategy_used')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            $table->foreign('user_bot_investment_id')->references('id')->on('user_bot_investments')->onDelete('cascade');
            $table->index(['user_bot_investment_id', 'result']);
            $table->index('opened_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bot_trading_history');
    }
};
