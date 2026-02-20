<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('child_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('sponsored_children')->onDelete('cascade');
            $table->string('title');
            $table->string('type'); // school_report, health_record, letter, certificate
            $table->string('file_path');
            $table->date('document_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('child_documents');
    }
};
