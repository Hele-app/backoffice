<?php

namespace App\Http\Wrapper;

use App\Providers\HeleUserProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class HeleApiWrapper
{
    private const ROUTES = [
        'login' => ['method' => 'POST', 'url' => '/auth/login'],
        'auth_check' => ['method' => 'GET', 'url' => '/auth/me'],
        'users.professionals_index' => ['method' => 'GET', 'url' => '/user/pro'],
        'users.youngs_index' => ['method' => 'GET', 'url' => '/user/young'],
    ];

    private const DEFAULT_HEADERS = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ];

    private $withPagination = false;
    private $withMapping = [];

    public function paginate(string $mapping)
    {
        $this->withPagination = true;
        $this->map($mapping, 'data');

        return $this;
    }

    public function map(string $mapping, string $field = '.')
    {
        $this->withMapping[$field] = $mapping;

        return $this;
    }

    private function checkForHeleApiResource(string $classname)
    {
        return in_array(HeleApiResource::class, class_implements($classname));
    }

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

        $response = $http_request->$method($url, $body);

        \Log::debug("$method $url");
        \Log::debug($response->body());
        if ($response->successful()) {
            $response = $response->json();

            foreach ($this->withMapping as $field => $mapping) {
                $data = $field === '.' ? $response : $response[$field];
                if (count(array_filter(array_keys($data), 'is_string')) > 0) {
                    // the field is a single entity, because it contains string keys
                    $data = $mapping::mapFromResponse($data);
                } else {
                    // the field is an array of entities, because it contains only numeric keys
                    $data = array_map(fn ($d) => $mapping::mapFromResponse($d), $data);
                }

                if ($field === '.') {
                    $response = $data;
                    break;
                } else {
                    $response[$field] = $data;
                }
            }
            $this->withMapping = [];

            if ($this->withPagination === true) {
                $this->withPagination = false;

                return new LengthAwarePaginator($response['data'], $response['total'], $response['perPage'], $response['page']);
            } else {
                return $response;
            }
        } else {
            \Log::error($response->json());
            $response->throw();

            return $response->json();
        }
    }

    public static function formatUrl($url)
    {
        return str_replace('//', '/', env('API_BASE_URL', 'http://localhost:3333/').$url);
    }
}
