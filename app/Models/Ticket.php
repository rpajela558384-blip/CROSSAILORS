<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(TicketReply::class)->oldest();
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'open'        => 'bg-green-100 text-green-800',
            'in_progress' => 'bg-yellow-100 text-yellow-800',
            'resolved'    => 'bg-gray-100 text-gray-600',
            default       => 'bg-gray-100 text-gray-600',
        };
    }
}
