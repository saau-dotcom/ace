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
        Schema::table('leads', function (Blueprint $table) {
            $table->string('lead_source')->nullable();
            $table->string('suburb')->nullable();
            $table->string('post_code')->nullable();
            $table->boolean('existing_system_installed')->default(false);
            $table->text('requirements')->nullable();
            $table->string('battery_model')->nullable();
            $table->string('inverter_model')->nullable();
            $table->string('panel_model')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'lead_source',
                'suburb',
                'post_code',
                'existing_system_installed',
                'requirements',
                'battery_model',
                'inverter_model',
                'panel_model'
            ]);
        });
    }
};
