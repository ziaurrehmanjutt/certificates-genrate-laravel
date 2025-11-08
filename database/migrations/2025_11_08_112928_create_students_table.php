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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // Name fields (split)
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100);

            // Contact information
            $table->string('email', 150); // Not unique - same student can enroll in multiple programs
            $table->string('phone', 20)->nullable();

            // Student identification
            $table->string('cnic', 50)->unique()->nullable(); // National ID - this should be unique per person
            $table->date('dob')->nullable(); // Date of Birth
            $table->enum('gender', ['male', 'female', 'other'])->nullable();

            // Profile image
            $table->string('profile_image')->nullable();

            // Additional information
            $table->text('address')->nullable();
            $table->string('father_name', 150)->nullable();
            $table->string('mother_name', 150)->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes(); // For soft delete functionality

            // Index for faster searching (limited length for MySQL)
            $table->index('email');
            $table->index(['first_name', 'last_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
