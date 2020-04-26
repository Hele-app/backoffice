<?php

namespace App\Http\Wrapper;

use App\Providers\HeleUserProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class HeleApiWrapper
{
    /* Routes and Headers have been moved to the end of the file for readibility */

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
        if ($this->checkForHeleApiResource($mapping)) {
            $this->withMapping[$field] = $mapping;
        }

        return $this;
    }

    private function checkForHeleApiResource(string $classname)
    {
        return in_array(HeleApiResource::class, class_implements($classname));
    }

    /**
     * RIP 25 lines method 💀.
     *
     * @param string|array $route     the route to call. Should be an an array containing in 0 the name of the route and the route parameters if any.
     * @param array        $body      the body to send. In case of a GET request, this becomes the querystring
     * @param array        $optionnal the optionnal data to send by the other mean (querystring in a POST, body in a GET)
     */
    public function call($route, array $body = [], array $optionnal = [])
    {
        if (is_string($route)) {
            $route = [$route];
        }

        $routeName = array_shift($route);
        $routeParams = &$route;

        if (!array_key_exists($routeName, self::ROUTES)) {
            abort(500);
        }

        $method = self::ROUTES[$routeName]['method'];
        $url = $this->formatUrl(self::ROUTES[$routeName]['url'], $routeParams, $optionnal);

        $http_request = Http::withHeaders(self::DEFAULT_HEADERS);

        if ($method === 'GET') {
            $optionnal = $body;
            $body = [];
        }

        if (session(HeleUserProvider::TOKEN, null)) {
            $http_request = $http_request->withToken(session(HeleUserProvider::TOKEN));
        }

        $time_before_request = hrtime(true);
        $response = $http_request->$method($url, $body);

        if (\App::bound('debugbar') && \App::make('debugbar')->hasCollector('queries')) {
            \App::make('debugbar')->getCollector('queries')->addQuery("$method $url\n{$response->body()}", $body, (hrtime(true) - $time_before_request) / 1e+6, \DB::connection());
        } else {
            \Log::debug("$method $url");
            \Log::debug($response->body());
        }

        if ($response->successful()) {
            $response = $response->json();

            foreach ($this->withMapping as $field => $mapping) {
                $data = $field === '.' ? $response : $response[$field];
                if (count(array_filter(array_keys($data), 'is_string')) > 0) {
                    // the field is a single entity, because it contains only string keys
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

    public function errors($response)
    {
        $response = $response->json();

        if (isset($response['errors'])) {
            return array_combine(
                array_map(fn ($e) => $e['field'], $response['errors']),
                array_map(fn ($e) => $e['message'], $response['errors'])
            );
        } else {
            return [];
        }
    }

    private function formatUrl(string $path, array $params, array $optionnal)
    {
        return str_replace('//', '/', config('app.hele_api_base_url').$this->replaceParameters($path, $params).'?'.http_build_query($optionnal));
    }

    private function replaceParameters(string $path, array $params)
    {
        return preg_replace_callback('/{(\w+)}/', function ($matches) use (&$params) {
            if (array_key_exists($matches[1], $params)) {
                $value = $params[$matches[1]];
                unset($params[$matches[1]]);

                return $value;
            } else {
                return '';
            }
        }, $path);
    }

    private const DEFAULT_HEADERS = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ];

    private const ROUTES = [
        'login' => ['method' => 'POST', 'url' => '/auth/login'],
        'auth_check' => ['method' => 'GET', 'url' => '/auth/me'],

        'users.professionals_index' => ['method' => 'GET', 'url' => '/user/pro'],
        'users.professionals_store' => ['method' => 'POST', 'url' => '/user/pro'],
        'users.professionals_show' => ['method' => 'GET', 'url' => '/user/pro/{id}'],
        'users.professionals_update' => ['method' => 'PATCH', 'url' => '/user/pro/{id}'],
        'users.professionals_destroy' => ['method' => 'DELETE', 'url' => '/user/pro/{id}'],

        'users.youngs_index' => ['method' => 'GET', 'url' => '/user/young'],
        'users.youngs_store' => ['method' => 'POST', 'url' => '/user/young'],
        'users.youngs_show' => ['method' => 'GET', 'url' => '/user/young/{id}'],
        'users.youngs_update' => ['method' => 'PATCH', 'url' => '/user/young/{id}'],
        'users.youngs_destroy' => ['method' => 'DELETE', 'url' => '/user/young/{id}'],
    ];
}
