<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Clan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'totem'];

    protected static function booted(): void
    {
        static::saving(function (Clan $clan) {
            if (blank($clan->slug)) {
                $clan->slug = Str::slug($clan->name);
            }
        });
    }

    public function people(): HasMany
    {
        return $this->hasMany(Person::class);
    }

    public function rulers(): HasMany
    {
        return $this->hasMany(Ruler::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
