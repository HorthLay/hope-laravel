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
        Schema::table('sponsor_messages', function (Blueprint $table) {
            $table->boolean('is_image')->default(false)->after('attachment_size');
            $table->json('link_preview')->nullable()->after('is_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sponsor_messages', function (Blueprint $table) {
             $table->dropColumn(['is_image', 'link_preview']);
        });
    }
};
