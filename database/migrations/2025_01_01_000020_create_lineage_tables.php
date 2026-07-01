<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Clans, people and traditional rulers.
 *
 * Lunguda society is matrilineal: descent and inheritance run through the
 * mother's line. The people table therefore records BOTH mother_id and
 * father_id, with mother_id treated as the primary lineage link so the
 * data model reflects the community's actual kinship system.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('totem')->nullable();
            $table->timestamps();
        });

        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender')->nullable();
            $table->foreignId('clan_id')->nullable()->constrained('clans')->nullOnDelete();
            $table->foreignId('mother_id')->nullable()->constrained('people')->nullOnDelete();
            $table->foreignId('father_id')->nullable()->constrained('people')->nullOnDelete();
            $table->integer('birth_year')->nullable();
            $table->integer('death_year')->nullable();
            $table->text('biography')->nullable();
            $table->string('status')->default('published')->index();
            $table->timestamps();
            $table->index('clan_id');
        });

        Schema::create('rulers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable();          // e.g. Chief of Jessu
            $table->foreignId('clan_id')->nullable()->constrained('clans')->nullOnDelete();
            $table->integer('reign_start')->nullable();
            $table->integer('reign_end')->nullable();
            $table->text('biography')->nullable();
            $table->text('accomplishments')->nullable();
            $table->text('vision')->nullable();           // their dreams / aspirations
            $table->string('portrait_path')->nullable();
            $table->integer('order_index')->default(0);   // manual ordering on the timeline
            $table->string('status')->default('published')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rulers');
        Schema::dropIfExists('people');
        Schema::dropIfExists('clans');
    }
};
