<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param array $response
     *
     * @return User
     */
    public static function mapFromResponse($response)
    {
        $user = new User();
        $user->id = $response['id'];
        $user->phone = $response['phone'];
        $user->username = $response['username'];
        $user->email = $response['email'];
        $user->role = $response['role'];
        $user->profession = $response['profession'];
        $user->city = $response['city'];
        $user->phone_pro = $response['phone_pro'];
        $user->active = $response['active'];

        return $user;
    }
}
