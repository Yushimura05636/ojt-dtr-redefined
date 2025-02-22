<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class File extends Model
{
    use HasFactory, Notifiable;
    
    protected $table = 'files';
    protected $guarded = [];
    //
    public function schools()
    {
        return $this->hasOne(School::class, 'file_id');
    }

    public function profiles(){
        return $this->hasOne(Profile::class, 'file_id');
    }
}

