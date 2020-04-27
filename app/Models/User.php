<?php

namespace App\Models;

use App\Http\Wrapper\HeleApiResource;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements HeleApiResource
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'phone',
        'username',
        'email',
        'birthyear',
        'establishment_id',
        'role',
        'profession',
        'city',
        'phone_pro',
        'active',
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

    public static function getRoles()
    {
        return ['YOUNG', 'MODERATOR', 'PROFESSIONAL', 'ADMIN'];
    }

    /**
     * @param array $data provided from the API
     *
     * @return User
     */
    public static function mapFromResponse(array $data)
    {
        $user = new User();
        $user->id = $data['id'];
        $user->phone = $data['phone'];
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->birthyear = $data['birthyear'];
        $user->establishment_id = $data['establishment_id'];
        // $user->establishment = Establishment::mapFromResponse($data['establishment']);
        $user->role = $data['role'];
        $user->profession = $data['profession'];
        $user->city = $data['city'];
        $user->phone_pro = $data['phone_pro'];
        $user->active = $data['active'];

        return $user;
    }
}
