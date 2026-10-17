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
        Schema::create('user_bot_investments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bot_id');
            $table->decimal('investment_amount', 15, 2);
            $table->decimal('current_balance', 15, 2);
            $table->decimal('total_profit', 15, 2)->default(0);
            $table->decimal('total_loss', 15, 2)->default(0);
            $table->integer('successful_trades')->default(0);
            $table->integer('failed_trades')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('last_profit_at')->nullable();
            $table->enum('status', ['active', 'completed', 'cancelled', 'expired'])->default('active');
            $table->boolean('auto_reinvest')->default(false);
            $table->decimal('reinvest_percentage', 5, 2)->default(0); // percentage to reinvest
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bot_id')->references('id')->on('trading_bots')->onDelete('cascade');
            $table->index(['user_id', 'bot_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_bot_investments');
    }
};
