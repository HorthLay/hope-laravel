<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('child_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('sponsored_children')->onDelete('cascade');
            $table->string('type'); // photo, video
            $table->string('file_path');
            $table->string('caption')->nullable();
            $table->date('taken_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('child_media');
    }
};
