<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsored_children', function (Blueprint $table) {
            $table->id();
            $table->string('first_name'); // Can be modified/pseudonym for privacy
            $table->string('code')->unique(); // Internal reference (e.g., "CAM-2024-001")
            $table->integer('birth_year');
            $table->text('story')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('country')->default('Cambodia');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsored_children');
    }
};
