<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CulturalItem extends Model
{
    use HasFactory;

    protected $table = 'cultural_items';

    protected $fillable = ['name','category','description','significance','materials','maker_name','image_path','status'];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }
}
