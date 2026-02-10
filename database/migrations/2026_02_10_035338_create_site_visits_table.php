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
        Schema::create('site_visits', function (Blueprint $table) {
             $table->id();
            $table->string('ip_address', 45)->index();
            $table->text('user_agent')->nullable();
            $table->string('page_url', 500)->index();
            $table->string('referrer', 500)->nullable();
            $table->enum('device_type', ['desktop', 'mobile', 'tablet'])->default('desktop')->index();
            $table->string('browser', 50)->nullable();
            $table->string('platform', 50)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->timestamp('visited_at')->index();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['ip_address', 'visited_at']);
            $table->index(['page_url', 'visited_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_visits');
    }
};
