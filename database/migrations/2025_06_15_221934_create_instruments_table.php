<?php
// database/migrations/xxxx_xx_xx_create_instruments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumentsTable extends Migration
{
    public function up()
    {
        Schema::create('instruments', function (Blueprint $table) {
            $table->id();
            $table->string('symbol')->unique();        // BTC/USD
            $table->string('name');                    // Bitcoin
            $table->string('type');                    // crypto, stock, forex, index

            // Market Data
            $table->decimal('open', 20, 8)->nullable();
            $table->decimal('high', 20, 8)->nullable();
            $table->decimal('low', 20, 8)->nullable();
            $table->decimal('close', 20, 8)->nullable();   // latest close
            $table->decimal('price', 20, 8)->nullable();   // live price
            $table->decimal('percent_change_24h', 10, 4)->nullable();
            $table->decimal('change', 20, 8)->nullable();  // price change
            $table->decimal('market_cap', 30, 2)->nullable();
            $table->decimal('volume', 30, 2)->nullable();

            // Media
            $table->string('logo')->nullable();           // URL or stored image

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instruments');
    }
}

