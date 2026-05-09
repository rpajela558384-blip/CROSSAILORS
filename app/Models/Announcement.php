<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'type',
        'title',
        'body',
        'link_url',
        'image_path',
        'category',
        'active',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'active'       => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)->latest('published_at');
    }
}
