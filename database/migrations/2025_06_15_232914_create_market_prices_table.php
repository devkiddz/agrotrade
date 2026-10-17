<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('market_prices', function (Blueprint $table) {
    $table->id();
    $table->foreignId('instrument_id')->constrained()->onDelete('cascade');

    $table->decimal('open', 20, 8);
    $table->decimal('high', 20, 8);
    $table->decimal('low', 20, 8);
    $table->decimal('close', 20, 8);
    $table->decimal('volume', 30, 8)->nullable();

    $table->string('interval')->default('1m');
    $table->timestamp('timestamp');

    $table->string('source')->nullable();

    $table->timestamps();

    $table->index(['instrument_id', 'timestamp', 'interval']);
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('market_prices');
    }
}
