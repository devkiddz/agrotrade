<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanPlanCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_category_plan', function (Blueprint $table) {
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_category_id')->constrained()->onDelete('cascade');
            $table->primary(['plan_id', 'plan_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_category_plan');
    }
}
