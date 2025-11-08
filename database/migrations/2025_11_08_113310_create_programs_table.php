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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Bachelor of Science", "Master of Arts"
            $table->string('code')->unique(); // e.g., "BS-CS", "MS-IT"
            $table->text('description')->nullable();
            $table->integer('duration_years')->default(4); // Program duration
            $table->enum('level', ['certificate', 'diploma', 'bachelor', 'master', 'phd'])->default('bachelor');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
