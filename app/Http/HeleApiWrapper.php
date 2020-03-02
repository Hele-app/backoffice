<?php

namespace App\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Validator;

class HeleApiWrapper
{
    private const BASE_URL = 'http://localhost:3333/v1/';
    private $client = null;
    private $headers = [];

    public function __construct()
    {
        $this->client = new Client();
        $this->headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    private function call($method = 'GET', $uri = '/', $data = [], $headers = [])
    {
        try {
            // if ($method === 'GET) {
            //     $uri .= http_build_query($data);
            // }

            $response = $this->client->request($method, self::BASE_URL.ltrim($uri, '/'), [
                'json' => $data,
                'headers' => array_merge($this->headers, $headers),
            ]);

            return json_decode($response->getBody());
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    public function login($data)
    {
        Validator::make($data, [
            'email' => 'required|string|email',
            'password' => 'required|string', // current : 'on75aoid2u'
        ])->validate();

        return $this->call('POST', '/auth/login', $data);
    }
}
