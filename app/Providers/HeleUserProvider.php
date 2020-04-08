<?php

namespace App\Providers;

use App\Http\Wrapper\HeleApiWrapper;
use App\Models\RememberToken;
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
        \Log::debug(__METHOD__." => id: $identifier");

        return $this->hele->map(User::class)->call('auth_check');
    }

    /**
     * @param string $identifier xxx
     * @param string $token      xxx
     *
     * @return User
     */
    public function retrieveByToken($identifier, $token)
    {
        \Log::debug(__METHOD__." => id: $identifier // token: $token");

        $remember_token = RememberToken::where('remember_token', $token)->first();

        if (!$remember_token) {
            return null;
        }

        session()->put(self::TOKEN, $remember_token->access_token);

        return $this->hele->map(User::class)->call('auth_check');
    }

    /**
     * @param Authenticatable $user  to update
     * @param string          $token to store if remembered
     *
     * @return bool
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        \Log::debug(__METHOD__." => user.phone: {$user->phone} // token: $token");

        if ($token) {
            return (bool) RememberToken::updateOrCreate(
                ['remember_token' => $token],
                ['access_token' => session()->get(self::TOKEN)],
            );
        }

        return false;
    }

    /**
     * @param array $credentials from the login form
     *
     * @return User
     */
    public function retrieveByCredentials(array $credentials)
    {
        \Log::debug(__METHOD__.' => credentials: '.json_encode($credentials));

        try {
            $response = $this->hele->map(User::class, 'user')->call('login', $credentials);

            session()->put(self::TOKEN, $response['accessToken']['token']);
            // session()->put(self::TOKEN.'_refresh', $response['accessToken']['refreshToken']);

            return $response['user'];
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
        \Log::debug(__METHOD__." => user.phone: {$user->phone} // credentials: ".json_encode($credentials));

        $response_user = $this->hele->map(User::class)->call('auth_check');

        return $response_user['email'] === $user->email && $response_user['email'] === $credentials['email'];
    }
}
