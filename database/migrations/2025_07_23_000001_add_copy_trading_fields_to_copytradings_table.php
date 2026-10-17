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
        Schema::table('copytradings', function (Blueprint $table) {
            // Add missing fields for the copy trading functionality
            $table->string('photo')->nullable()->after('name'); // Trader photo
            $table->integer('rating')->default(5)->after('photo'); // Trader rating (1-5)
            $table->integer('followers')->default(0)->after('rating'); // Number of followers
            $table->decimal('equity', 8, 2)->default(0)->after('followers'); // Profit rate percentage
            $table->decimal('total_profit', 15, 2)->default(0)->after('equity'); // Total profit generated
            $table->enum('status', ['active', 'inactive'])->default('active')->after('total_profit'); // Status
            $table->text('description')->nullable()->after('status'); // Trader description
            $table->integer('win_rate')->default(80)->after('description'); // Win rate percentage
            $table->integer('total_trades')->default(0)->after('win_rate'); // Total number of trades
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('copytradings', function (Blueprint $table) {
            $table->dropColumn([
                'photo',
                'rating',
                'followers',
                'equity',
                'total_profit',
                'status',
                'description',
                'win_rate',
                'total_trades'
            ]);
        });
    }
};
