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
        Schema::create('sponsor_notification_reads', function (Blueprint $table) {
               $table->id();
            $table->unsignedBigInteger('sponsor_id');
            // child_update | family_update | child_document | family_document
            $table->string('notifiable_type', 30);
            $table->unsignedBigInteger('notifiable_id');
            $table->timestamp('created_at')->useCurrent();
 
            $table->foreign('sponsor_id')
                  ->references('id')->on('sponsors')
                  ->onDelete('cascade');
 
            // One read-record per sponsor per item
            $table->unique(
                ['sponsor_id', 'notifiable_type', 'notifiable_id'],
                'notif_read_unique'
            );
            $table->index(['sponsor_id', 'notifiable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsor_notification_reads');
    }
};
