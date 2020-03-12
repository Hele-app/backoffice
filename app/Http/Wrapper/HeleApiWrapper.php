<?php

namespace App\Http\Wrapper;

use App\Providers\HeleUserProvider;
use Illuminate\Support\Facades\Http;

class HeleApiWrapper
{
    private const ROUTES = [
        'login' => ['method' => 'POST', 'url' => '/auth/login'],
    ];

    private const DEFAULT_HEADERS = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ];

    public function call(string $routeName, array $body = [], array $headers = [])
    {
        if (!array_key_exists($routeName, self::ROUTES)) {
            abort(500);
        }

        $method = self::ROUTES[$routeName]['method'];
        $url = self::formatUrl(self::ROUTES[$routeName]['url']);

        $http_request = Http::withHeaders(array_merge(self::DEFAULT_HEADERS, $headers));

        if ($method === 'GET') {
            $url .= '?'.http_build_query($body);
            $body = [];
        }

        if (session(HeleUserProvider::TOKEN, null)) {
            $http_request = $http_request->withToken(session(HeleUserProvider::TOKEN));
        }

        $response = $http_request->$method($url, $body); // ->throw()->json();

        if ($response->successful()) {
            return $response->json();
        } else {
            \Log::error($response->json());
            $response->throw();
        }
    }

    public static function formatUrl($url)
    {
        return str_replace('//', '/', env('API_BASE_URL', 'http://localhost:3333/').$url);
    }
}
