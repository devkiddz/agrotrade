<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgrotradeTransferRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('agrotrade_transfer_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->char('payload_hash', 64);
            $table->timestamps();
            $table->index(['sender_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('agrotrade_transfer_requests');
    }
}
