<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgrotradeInvestmentControls extends Migration
{
    public function up()
    {
        Schema::create('agrotrade_investment_controls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('investment_type', 16);
            $table->unsignedBigInteger('investment_id');
            $table->string('state', 16);
            $table->string('reason', 1000);
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->unique(['investment_type', 'investment_id'], 'agrotrade_investment_control_unique');
        });
        Schema::create('agrotrade_investment_control_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('investment_type', 16);
            $table->unsignedBigInteger('investment_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('action', 24);
            $table->string('from_state', 16);
            $table->string('to_state', 16);
            $table->string('reason', 1000);
            $table->timestamp('created_at');
            $table->index(['investment_type', 'investment_id'], 'agrotrade_inv_event_lookup');
        });
    }
    public function down()
    {
        Schema::dropIfExists('agrotrade_investment_control_events');
        Schema::dropIfExists('agrotrade_investment_controls');
    }
}

