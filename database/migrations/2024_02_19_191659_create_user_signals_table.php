<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSignalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_signals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('Asset')->nullable();
            $table->integer('user')->nullable();
            $table->integer('signals')->nullable();
            $table->integer('order_type')->nullable();
            $table->string('price')->nullable();
            $table->string('status')->nullable();
            $table->string('leverage')->nullable();
            $table->datetime('expiration')->nullable();
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
        Schema::dropIfExists('user_signals');
    }
}
