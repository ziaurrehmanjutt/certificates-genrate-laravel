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
        Schema::table('certificate_templates', function (Blueprint $table) {
            $table->json('name')->nullable()->change();
            $table->json('description')->nullable()->change();

            $table->string('background_image_path')->nullable()->after('description');
            $table->string('orientation')->default('landscape')->after('background_image_path');
            $table->string('font_family')->nullable()->after('orientation');
            $table->json('extra_config')->nullable()->after('font_family');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificate_templates', function (Blueprint $table) {
            $table->string('name')->change();
            $table->text('description')->change();

            $table->dropColumn([
                'background_image_path',
                'orientation',
                'font_family',
                'extra_config',
            ]);
        });
    }
};
