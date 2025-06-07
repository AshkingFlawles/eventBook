<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            if (!Schema::hasColumn('venues', 'currency')) {
                $table->string('currency', 10)->default('USD')->after('type');
            }
            if (!Schema::hasColumn('venues', 'slug')) {
                $table->string('slug')->nullable()->after('name');
            }
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
            if (Schema::hasColumn('venues', 'currency')) {
                $table->dropColumn('currency');
            }
        });
    }
}
