<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'database_limit'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
