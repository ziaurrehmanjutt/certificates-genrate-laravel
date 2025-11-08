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
        Schema::create('class_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Section A", "Batch 2024"
            $table->foreignId('program_id')->nullable()->constrained('programs')->onDelete('cascade');
            $table->string('session')->nullable(); // e.g., "2024-2025", "Fall 2024"
            $table->integer('year')->nullable(); // Academic year
            $table->string('semester')->nullable(); // e.g., "1st", "2nd", "Fall", "Spring"
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_sections');
    }
};
