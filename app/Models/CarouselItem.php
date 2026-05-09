<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarouselItem extends Model
{
    protected $fillable = [
        'type',
        'image_path',
        'title',
        'caption',
        'link_url',
        'order',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'order'  => 'integer',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)->orderBy('order');
    }
}
