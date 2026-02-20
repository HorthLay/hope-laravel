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
        Schema::create('sponsor_sponsored_child', function (Blueprint $table) {
           $table->id();
        $table->foreignId('sponsor_id')
              ->constrained('sponsors')
              ->onDelete('cascade');
        $table->foreignId('sponsored_child_id')
              ->constrained('sponsored_children')
              ->onDelete('cascade');
        $table->unique(['sponsor_id', 'sponsored_child_id']);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsor_sponsored_child');
    }
};
