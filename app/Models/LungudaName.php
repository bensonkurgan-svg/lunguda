<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LungudaName extends Model
{
    use HasFactory;

    protected $table = 'lunguda_names';

    protected $fillable = [
        'name', 'meaning', 'origin', 'gender', 'dialect',
        'audio_path', 'status', 'contributed_by', 'approved_by',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }
}
