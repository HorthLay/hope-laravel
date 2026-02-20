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
       // 1. Families table (standalone — NOT linked to sponsored_children)
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable()->unique();
            $table->string('country')->nullable();
            $table->text('story')->nullable();
            $table->string('profile_photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Sponsor <-> Family pivot
        Schema::create('sponsor_family', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->onDelete('cascade');
            $table->foreignId('family_id')->constrained('families')->onDelete('cascade');
            $table->unique(['sponsor_id', 'family_id']);
            $table->timestamps();
        });

        // 3. Family media (photos & videos — mirrors child_media)
        Schema::create('family_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained('families')->onDelete('cascade');
            $table->string('file_path');
            $table->enum('type', ['photo', 'video'])->default('photo');
            $table->string('caption')->nullable();
            $table->date('taken_date')->nullable();
            $table->timestamps();
        });

        // 4. Family documents (mirrors child_documents)
        Schema::create('family_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained('families')->onDelete('cascade');
            $table->string('title');
            $table->string('file_path');
            $table->string('type')->nullable();
            $table->date('document_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('family_documents');
        Schema::dropIfExists('family_media');
        Schema::dropIfExists('sponsor_family');
        Schema::dropIfExists('families');
    }
};
