<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webspace extends Model
{
    protected $fillable = [
        'user_id',
        'domain',
        'path',
        'status',
        'type',
        'deploy_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
