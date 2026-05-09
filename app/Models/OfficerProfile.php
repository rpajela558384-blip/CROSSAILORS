<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class OfficerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'position',
        'bio',
        'contact_info',
        'photo',
        'display_order',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
