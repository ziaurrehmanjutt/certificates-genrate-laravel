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
        Schema::create('certificate_template_fields', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('template_id'); // Reference to certificate_templates (to be created if not exists)

            $table->string('key')->unique(); // e.g., "student_name", "issue_date"
            $table->json('label'); // { "en": "Student Name", "ur": "طالب علم کا نام" }
            $table->string('type')->default('text'); // text, image, date, etc.
            $table->json('default_value')->nullable(); // e.g., "ABC Institute"
            $table->boolean('is_required')->default(false);
            $table->json('help_text')->nullable();
            $table->json('extra_data')->nullable();
            // source_type: system_field / custom_field / static_value
            $table->enum('source_type', ['system', 'custom', 'static'])->default('static');

            // If source_type == system -> system field key like "name", "email"
            // If source_type == custom -> key of student_dynamic_fields
            // If source_type == static -> use default_value
            $table->string('source_key')->nullable();

            $table->timestamps();

            // Foreign key constraint (optional)
            $table->foreign('template_id')->references('id')->on('certificate_templates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_template_fields');
    }
};
