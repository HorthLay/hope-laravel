<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('child_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('sponsored_children')->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->string('type')->default('report'); // report, letter, news, milestone
            $table->date('report_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('child_updates');
    }
};
