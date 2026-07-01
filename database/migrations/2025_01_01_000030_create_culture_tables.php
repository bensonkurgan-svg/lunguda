<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Intangible & material culture: oral traditions, attire/craft items,
 * monuments & sacred sites, and the general gallery.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oral_traditions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->default('story')->index(); // story|proverb|song|history
            $table->string('narrator_name')->nullable();
            $table->string('dialect')->default('Guyuk')->index();
            $table->longText('transcript')->nullable();
            $table->longText('translation')->nullable();
            $table->string('audio_path')->nullable();
            $table->string('video_url')->nullable();
            $table->date('recorded_on')->nullable();
            $table->boolean('consent_given')->default(false);
            $table->string('status')->default('published')->index();
            $table->foreignId('contributed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('cultural_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->default('attire')->index(); // attire|craft|regalia|instrument|food
            $table->text('description')->nullable();
            $table->text('significance')->nullable();
            $table->string('materials')->nullable();
            $table->string('maker_name')->nullable();
            $table->string('image_path')->nullable();
            $table->string('status')->default('published')->index();
            $table->timestamps();
        });

        Schema::create('monuments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('monument')->index(); // monument|sacred_site|landmark
            $table->text('description')->nullable();
            $table->text('significance')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('image_path')->nullable();
            $table->string('status')->default('published')->index();
            $table->timestamps();
        });

        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->string('caption')->nullable();
            $table->string('category')->default('general')->index(); // general|chief|cultural
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oral_traditions');
        Schema::dropIfExists('cultural_items');
        Schema::dropIfExists('monuments');
        Schema::dropIfExists('gallery_images');
    }
};
