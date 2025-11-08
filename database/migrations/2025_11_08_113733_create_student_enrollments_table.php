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
        Schema::create('student_enrollments', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->foreignId('class_id')->nullable()->constrained('class_sections')->onDelete('set null');

            // Enrollment specific identifiers
            $table->string('roll_no')->unique(); // Unique per enrollment
            $table->string('registration_no')->unique()->nullable();

            // Dates
            $table->date('admission_date')->nullable();
            $table->date('graduation_date')->nullable();

            // Status
            $table->enum('status', ['admitted', 'active', 'passed_out', 'dropped', 'expelled', 'transferred'])->default('admitted');

            // Certificate information
            $table->enum('certificate_status', ['pending', 'generated', 'issued', 'revoked'])->default('pending');
            $table->date('certificate_issued_date')->nullable();
            $table->string('certificate_number')->unique()->nullable();

            // Academic performance
            $table->decimal('cgpa', 3, 2)->nullable();
            $table->string('grade')->nullable(); // A+, A, B+, etc.

            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Composite unique constraint - same student can't enroll in same program twice (unless one is deleted)
            $table->unique(['student_id', 'program_id', 'roll_no']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_enrollments');
    }
};
