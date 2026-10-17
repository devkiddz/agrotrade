<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWalletsTableForEnhancedFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallets', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('wallets', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('phrase');
            }

            if (!Schema::hasColumn('wallets', 'last_validated')) {
                $table->timestamp('last_validated')->nullable()->after('status');
            }

            // Ensure user column has proper indexing for performance
            $table->index('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropColumn(['status', 'last_validated']);
            $table->dropIndex(['user']);
        });
    }
}
