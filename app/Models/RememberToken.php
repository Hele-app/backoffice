<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RememberToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'remember_token', 'access_token',
    ];
}
