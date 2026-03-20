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
        Schema::create('donation_projects', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_fr')->nullable();
            $table->string('title_km')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_km')->nullable();
            $table->string('image')->nullable();          // stored path e.g. uploads/projects/xxx.jpg
            $table->string('helloasso_widget_url')->nullable();    // .../widget (donation form)
            $table->string('helloasso_counter_url')->nullable();   // .../widget-compteur (progress counter)
            $table->string('helloasso_vignette_url')->nullable();  // .../widget-vignette (card preview)
            $table->json('tags')->nullable();             // ["Food","Children","Cambodia"]
            $table->string('badge_label')->default('Active');
            $table->string('badge_color')->default('orange'); // orange | green | blue | gray
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_projects');
    }
};
