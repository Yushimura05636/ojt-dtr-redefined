<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Histories extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];
    //
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

