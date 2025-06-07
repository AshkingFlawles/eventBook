<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPricePerDayColumnToVenuesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            if (!Schema::hasColumn('venues', 'price_per_day')) {
                $table->decimal('price_per_day', 10, 2)->nullable()->after('price_per_hour');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            if (Schema::hasColumn('venues', 'price_per_day')) {
                $table->dropColumn('price_per_day');
            }
        });
    }
}
