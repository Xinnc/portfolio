<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'project_date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(Project_media::class);
    }

    public function getTypeAttribute(): string
    {
        return $this->media->contains(fn($m) => !is_null($m->video_url)) ? 'video' : 'image';
    }
}
