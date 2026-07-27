<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'cover_image',
        'description',
        'sort_order',
    ];

    protected $appends = ['url'];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' .  $this->cover_image);
    }
}
