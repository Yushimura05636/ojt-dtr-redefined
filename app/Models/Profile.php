<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = "profiles";
    protected $guarded = [];


    public function users(){
        return $this->hasOne(User::class, 'profile_id');
    }

    public function files(){
        return $this->belongsTo(File::class, 'file_id');
    }
}
