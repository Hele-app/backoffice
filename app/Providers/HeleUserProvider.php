<?php

namespace App\Providers;

use App\Http\Wrapper\HeleApiWrapper;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Client\RequestException;
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
     * @param int $identifier xxx
     *
     * @return User
     */
    public function retrieveById($identifier)
    {
        $response = $this->hele->call('auth_check');

        return User::mapFromResponse($response);
    }

    /**
     * @param string $identifier xxx
     * @param string $token      xxx
     *
     * @return User
     */
    public function retrieveByToken($identifier, $token)
    {
        $response = $this->hele->call('auth_check');

        return User::mapFromResponse($response);
    }

    /**
     * @param Authenticatable $user  to update
     * @param string          $token to store if remembered
     *
     * @return bool
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        return false;
    }

    /**
     * @param array $credentials from the login form
     *
     * @return User
     */
    public function retrieveByCredentials(array $credentials)
    {
        try {
            $response = $this->hele->call('login', $credentials);

            $user = User::mapFromResponse($response['user']);

            session()->put(self::TOKEN, $response['accessToken']['token']);
            session()->put(self::TOKEN.'_refresh', $response['accessToken']['refreshToken']);

            return $user;
        } catch (RequestException $e) {
            return null;
        }
    }

    /**
     * @param Authenticatable $user        currently logged in
     * @param array           $credentials to test
     *
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $response = $this->hele->call('auth_check');
        $response_user = User::mapFromResponse($response);

        return $response_user['email'] === $user->email && $response_user['email'] === $credentials['email'];
    }
}
