<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monument extends Model
{
    use HasFactory;

    protected $table = 'monuments';

    protected $fillable = ['name','type','description','significance','latitude','longitude','image_path','status'];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }
}
