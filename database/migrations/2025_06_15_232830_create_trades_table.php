<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('trades', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('instrument_id')->constrained()->onDelete('cascade');
    $table->enum('side', ['buy', 'sell']);
    $table->decimal('amount', 20, 2); // user puts in $100
    $table->decimal('leverage', 5, 2)->default(1.0);

    $table->decimal('entry_price', 20, 8);
    $table->decimal('exit_price', 20, 8)->nullable();

    $table->decimal('pnl', 20, 8)->nullable();
    $table->enum('status', ['open', 'closed'])->default('open');

    $table->decimal('stop_loss', 20, 8)->nullable();
    $table->decimal('take_profit', 20, 8)->nullable();

    $table->timestamp('opened_at')->nullable();
    $table->timestamp('closed_at')->nullable();

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
        Schema::dropIfExists('trades');
    }
}
