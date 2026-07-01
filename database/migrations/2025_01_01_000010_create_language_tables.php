<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Language documentation tables: words, phrases and personal names.
 * Every record carries a dialect tag (Cerin, Deele, Guyuk, Gwaanda, Kɔla),
 * a moderation status, and provenance (who recorded it + consent) so the
 * data is archival-grade and depositable to ELAR.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('word');
            $table->string('dialect')->default('Guyuk')->index();
            $table->string('part_of_speech')->nullable();
            $table->text('meaning');
            $table->string('ipa')->nullable();
            $table->text('example_sentence')->nullable();
            $table->text('example_translation')->nullable();
            $table->string('audio_path')->nullable();
            // Provenance / consent
            $table->string('recorded_by_name')->nullable();
            $table->date('recorded_on')->nullable();
            $table->boolean('consent_given')->default(false);
            // Moderation workflow
            $table->string('status')->default('published')->index();
            $table->foreignId('contributed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index('word');
        });

        Schema::create('phrases', function (Blueprint $table) {
            $table->id();
            $table->text('phrase');
            $table->text('translation');
            $table->string('category')->default('daily_life')->index();
            $table->string('dialect')->default('Guyuk')->index();
            $table->text('usage_notes')->nullable();
            $table->string('audio_path')->nullable();
            $table->string('recorded_by_name')->nullable();
            $table->boolean('consent_given')->default(false);
            $table->string('status')->default('published')->index();
            $table->foreignId('contributed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('lunguda_names', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('meaning');
            $table->text('origin')->nullable();
            $table->string('gender')->default('unisex');
            $table->string('dialect')->default('Guyuk')->index();
            $table->string('audio_path')->nullable();
            $table->string('status')->default('published')->index();
            $table->foreignId('contributed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('words');
        Schema::dropIfExists('phrases');
        Schema::dropIfExists('lunguda_names');
    }
};
