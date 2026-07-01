<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OralTradition extends Model
{
    use HasFactory;

    protected $table = 'oral_traditions';

    protected $fillable = [
        'title', 'type', 'narrator_name', 'dialect', 'transcript',
        'translation', 'audio_path', 'video_url', 'recorded_on',
        'consent_given', 'status', 'contributed_by', 'approved_by',
    ];

    protected function casts(): array
    {
        return ['recorded_on' => 'date', 'consent_given' => 'boolean'];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }
}
