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
        Schema::create('sponsor_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thread_id')
                ->constrained('sponsor_message_threads')
                ->cascadeOnDelete();
            $table->enum('sender', ['sponsor', 'admin']);
            $table->text('body')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('attachment_name')->nullable();
            $table->string('attachment_size')->nullable();
            $table->timestamp('read_at')->nullable(); // null = unread
            $table->timestamps();
            $table->index(['thread_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsor_messages');
    }
};
