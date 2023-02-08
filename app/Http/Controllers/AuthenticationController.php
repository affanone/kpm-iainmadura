<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

use App\Models\User;

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
            $response = $client->post(env("API_SERVER") . "/auth", [
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
            $token = json_decode($data);
            $user = User::where("username", $token->user->username)->first();
            if ($user) {
                // data ada di database kpm
            } else {
                // data tidak ada
                session([
                    "token_api" => $token, // token hasil login api
                    "register" => false, // false artinya tidak ada di database
                ]);
                return Redirect::to("reg");
            }

            // if ($user) {
            //     Auth::login($user);
            //     Session::put("token_api", $token->token);
            //     Log::set("Melakukan login", "login");
            //     return Redirect::to("mhs");
            // } else {
            //     return Redirect::to("signin")
            //         ->withErrors(
            //             "Data anda tidak ditemukan pada sistem, silahkan untuk menghubungi pengembang",
            //             "login"
            //         )
            //         ->withInput();
            // }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $result = json_decode($response->getBody()->getContents(), true);
            return Redirect::to("signin")
                ->withErrors($result, "login")
                ->withInput();
        }
    }
}
