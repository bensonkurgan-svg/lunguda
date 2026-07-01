<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phrase extends Model
{
    use HasFactory;

    protected $fillable = [
        'phrase', 'translation', 'category', 'dialect', 'usage_notes',
        'audio_path', 'recorded_by_name', 'consent_given',
        'status', 'contributed_by', 'approved_by',
    ];

    protected function casts(): array
    {
        return ['consent_given' => 'boolean'];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }
}
