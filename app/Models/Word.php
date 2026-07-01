<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Word extends Model
{
    use HasFactory;

    protected $fillable = [
        'word', 'dialect', 'part_of_speech', 'meaning', 'ipa',
        'example_sentence', 'example_translation', 'audio_path',
        'recorded_by_name', 'recorded_on', 'consent_given',
        'status', 'contributed_by', 'approved_by',
    ];

    protected function casts(): array
    {
        return ['recorded_on' => 'date', 'consent_given' => 'boolean'];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function contributor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contributed_by');
    }
}
