<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Database extends Model
{
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'user_id',
        'database_name',
        'database_user',
        'charset',
        'collation',
        'status',
    ];
}
