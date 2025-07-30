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
        Schema::create('student_dynamic_fields', function (Blueprint $table) {
            $table->id();
            $table->json('label'); // e.g., { "en": "CNIC Number", "ur": "شناختی کارڈ نمبر" }
            $table->string('key')->unique(); // e.g., "cnic_number"
            $table->string('type')->default('text'); // text, number, date, select, etc.
            $table->json('options')->nullable(); // for dropdown: e.g., [ "Option1", "Option2" ]
            $table->string('default_value')->nullable(); // default value(s)
            $table->json('help_text')->nullable(); // multi-language description/help
            $table->boolean('is_required')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_dynamic_fields');
    }
};
