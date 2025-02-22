<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    
    protected $table = 'schools';
    protected $guarded = [];

    
    public function users(){
        return $this->hasOne(User::class, 'school_id');
    }

    public function files(){
        return $this->belongsTo(File::class, 'file_id');
    }
}
