<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // We named this 'installations' to avoid a conflict with Laravel's internal 'jobs' table
        Schema::create('installations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();
            $table->foreignId('quote_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assigned_installer_id')->constrained('users')->cascadeOnDelete();
            $table->date('scheduled_date');
            $table->string('status')->default('Scheduled');
            $table->text('electrician_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installations');
    }
};