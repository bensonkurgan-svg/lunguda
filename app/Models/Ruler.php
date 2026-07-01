<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ruler extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'title', 'clan_id', 'reign_start', 'reign_end',
        'biography', 'accomplishments', 'vision', 'portrait_path',
        'order_index', 'status',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function clan(): BelongsTo
    {
        return $this->belongsTo(Clan::class);
    }

    public function reignLabel(): string
    {
        if (! $this->reign_start && ! $this->reign_end) {
            return 'Dates unknown';
        }

        return trim(($this->reign_start ?? '?').' – '.($this->reign_end ?? 'present'));
    }
}
