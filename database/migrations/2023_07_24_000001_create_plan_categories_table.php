<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Create pivot table for many-to-many relationship between plans and categories
        Schema::create('plan_plan_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('plan_category_id');

            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->foreign('plan_category_id')->references('id')->on('plan_categories')->onDelete('cascade');

            // Prevent duplicate associations
            $table->unique(['plan_id', 'plan_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_plan_category');
        Schema::dropIfExists('plan_categories');
    }
}
