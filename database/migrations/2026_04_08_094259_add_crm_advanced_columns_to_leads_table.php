<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->decimal('system_size_kw', 8, 2)->nullable();
            $table->string('battery_capacity_kwh')->nullable();
            $table->integer('stc_claimable')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['system_size_kw', 'battery_capacity_kwh', 'stc_claimable']);
        });
    }
};
