<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('plan_plan_category')) {
            Schema::create('plan_plan_category', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('plan_id');
                $table->unsignedBigInteger('plan_category_id');
                $table->timestamps();

                // Add foreign key constraints if possible, but don't fail if they can't be created
                try {
                    $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
                    $table->foreign('plan_category_id')->references('id')->on('plan_categories')->onDelete('cascade');
                } catch (\Exception $e) {
                    // Continue without constraints if they can't be created
                }

                $table->unique(['plan_id', 'plan_category_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_plan_category');
    }
};
