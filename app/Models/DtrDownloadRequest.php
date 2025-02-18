<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DtrDownloadRequest extends Model
{
    use HasFactory;

    protected $table = 'download_requests';

    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
