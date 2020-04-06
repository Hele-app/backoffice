<?php

namespace App\Providers;

use App\Http\Wrapper\HeleApiWrapper;
use App\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\ServiceProvider;

class HeleUserProvider extends ServiceProvider implements UserProvider
{
    /**
     * An instance of HeleApiWrapper.
     *
     * @var HeleApiWrapper
     */
    private $hele = null;

    /**
     * The session key that will hold the token from the Api.
     *
     * @var string
     */
    const TOKEN = 'hele_api_jwt';

    /**
     * Initialize the service.
     */
    public function __construct()
    {
        $this->hele = new HeleApiWrapper();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Provide services.
     *
     * @return HeleUserProvider
     */
    public function provides()
    {
        return [$this];
    }

    /**
     * @return User
     */
    public function retrieveById($identifier)
    {
        // TODO: call GET /auth/me to validate that the token is still valid or attempt to refresh it
        return session()->get('user');
    }

    /**
     * @return User
     */
    public function retrieveByToken($identifier, $token)
    {
        // TODO: call GET /auth/me to validate that the token is still valid or attempt to refresh it
        return session()->get('user');
    }

    /**
     * @return bool
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        return false;
    }

    /**
     * @return User
     */
    public function retrieveByCredentials(array $credentials)
    {
        $response = $this->hele->call('login', $credentials);

        $user = User::mapResponseToUser($response['user']);

        session()->put(self::TOKEN, $response['accessToken']['token']);
        session()->put(self::TOKEN.'_refresh', $response['accessToken']['refreshToken']);

        session()->put('user', $user);

        return $user;
    }

    /**
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // TODO: call GET /auth/me to validate that the token is correct and matches the $user
        return session()->has(self::TOKEN);
    }
}
