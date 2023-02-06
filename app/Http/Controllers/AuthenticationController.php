<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use GuzzleHttp\Client;

class AuthenticationController extends Controller
{
    public function index()
    {
        return view("login_page.index");
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id_login" => "required",
            "password" => "required",
        ]);
        if ($validator->fails()) {
            return Redirect::to("signin")
                ->withErrors($validator, "login")
                ->withInput();
        }
        try {
            $client = new Client();
            $response = $client->post(env("API_LOGIN"), [
                "form_params" => [
                    "username" => $request->id_login,
                    "password" => $request->password,
                    "logout" => 1,
                ],
                "headers" => [
                    "Auth-api-key" => env("API_KEY"),
                ],
                "verify" => false,
            ]);
            $data = $response->getBody()->getContents();
            $token = json_decode($data, true)->user;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $result = json_decode($response->getBody()->getContents(), true);
            return Redirect::to("signin")
                ->withErrors($result, "login")
                ->withInput();
        }
    }
}
