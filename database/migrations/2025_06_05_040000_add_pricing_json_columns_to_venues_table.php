<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPricingJsonColumnsToVenuesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            if (!Schema::hasColumn('venues', 'pricing_tiers')) {
                $table->json('pricing_tiers')->nullable()->after('facilities');
            }
            if (!Schema::hasColumn('venues', 'pricing_packages')) {
                $table->json('pricing_packages')->nullable()->after('pricing_tiers');
            }
            if (!Schema::hasColumn('venues', 'subscription_plans')) {
                $table->json('subscription_plans')->nullable()->after('pricing_packages');
            }
            if (!Schema::hasColumn('venues', 'additional_fees')) {
                $table->json('additional_fees')->nullable()->after('subscription_plans');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            if (Schema::hasColumn('venues', 'pricing_tiers')) {
                $table->dropColumn('pricing_tiers');
            }
            if (Schema::hasColumn('venues', 'pricing_packages')) {
                $table->dropColumn('pricing_packages');
            }
            if (Schema::hasColumn('venues', 'subscription_plans')) {
                $table->dropColumn('subscription_plans');
            }
            if (Schema::hasColumn('venues', 'additional_fees')) {
                $table->dropColumn('additional_fees');
            }
        });
    }
}
