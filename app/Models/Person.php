<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'gender', 'clan_id', 'mother_id', 'father_id',
        'birth_year', 'death_year', 'biography', 'status',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function clan(): BelongsTo
    {
        return $this->belongsTo(Clan::class);
    }

    // Matrilineal-first: mother is the primary lineage link.
    public function mother(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'mother_id');
    }

    public function father(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'father_id');
    }

    public function childrenByMother(): HasMany
    {
        return $this->hasMany(Person::class, 'mother_id');
    }

    public function childrenByFather(): HasMany
    {
        return $this->hasMany(Person::class, 'father_id');
    }
}
