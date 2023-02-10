<?php

namespace App;
use GuzzleHttp\Client;

class IainApi
{
    public static function post($url, $data = [])
    {
        try {
            return session("token_api")->token;
            $client = new Client();
            $response = $client->post(env("API_SERVER") . "/" . $url, [
                "form_params" => $data,
                "headers" => [
                    "Auth-api-key" => env("API_KEY"),
                    "Auth-token" => session("token_api")->token,
                ],
                "verify" => false,
            ]);
            $data = $response->getBody()->getContents();
            $n = new \stdClass();
            $n->status = true;
            $n->data = json_decode($data);
            return $n;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $result = json_decode($response->getBody()->getContents(), true);
            $n = new \stdClass();
            $n->status = false;
            $n->data = $result;
            return $n;
        }
    }

    public static function get($url, $data = [])
    {
        try {
            $client = new Client();
            $response = $client->get(env("API_SERVER") . "/" . $url, [
                "form_params" => $data,
                "headers" => [
                    "Auth-api-key" => env("API_KEY"),
                    "Auth-token" => session("token_api")->token,
                ],
                "verify" => false,
            ]);
            $data = $response->getBody()->getContents();
            $n = new \stdClass();
            $n->status = true;
            $n->data = json_decode($data);
            return $n;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $result = json_decode($response->getBody()->getContents(), true);
            $n = new \stdClass();
            $n->status = false;
            $n->data = $result;
            return $n;
        }
    }
}
