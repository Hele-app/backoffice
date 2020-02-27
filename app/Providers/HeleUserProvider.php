<?php

namespace App\Providers;

use App\Http\HeleApiWrapper;
use App\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\ServiceProvider;

class HeleUserProvider extends ServiceProvider implements UserProvider
{
    private $hele = null;

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const TOKEN = 'hele_api_jwt';

    public function __construct()
    {
        $this->hele = new HeleApiWrapper();
    }

    public function register()
    {
    }

    public function provides()
    {
        return [$this];
    }

    public function retrieveById($identifier)
    {
        // TODO: call GET /auth/me to validate that the token is still valid or attempt to refresh it
        return session()->get('user');
    }

    public function retrieveByToken($identifier, $token)
    {
        // TODO: call GET /auth/me to validate that the token is still valid or attempt to refresh it
        return session()->get('user');
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        return false;
    }

    public function retrieveByCredentials(array $credentials)
    {
        $response = $this->hele->login($credentials);

        $user = $this->mapResponseToUser($response);

        session()->put(self::TOKEN, $response->access_token->token);
        session()->put(self::TOKEN.'_refresh', $response->access_token->refreshToken);

        session()->put('user', $user);

        return $user;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // TODO: call GET /auth/me to validate that the token is correct and matches the $user
        return session()->has(self::TOKEN);
    }

    private function mapResponseToUser($response)
    {
        $user = new User();
        $user->id = $response->user->id;
        $user->phone = $response->user->phone;
        $user->username = $response->user->username;
        $user->email = $response->user->email;
        $user->role = $response->user->role;
        $user->profession = $response->user->profession;
        $user->city = $response->user->city;
        $user->phone_pro = $response->user->phone_pro;
        $user->active = $response->user->active;

        return $user;
    }
}
