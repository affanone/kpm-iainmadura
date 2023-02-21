<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\TahunAkademik;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
        $token = null;
        $result = null;
        try {

            $client = new Client();
            $response = $client->post(env("API_SERVER") . "/api/auth", [
                "form_params" => [
                    "username" => $request->id_login,
                    "password" => $request->password,
                    "logout" => 0,
                ],
                "headers" => [
                    "Auth-api-key" => env("API_KEY"),
                ],
                "verify" => false,
            ]);
            $data = $response->getBody()->getContents();
            $token = json_decode($data);
        } catch (\GuzzleHttp\Exception\ClientException$e) {
            $response = $e->getResponse();
            $result = json_decode($response->getBody()->getContents(), true);
        }
        if ($token) {
            $user = User::where(
                "username",
                $token->user->kode
            )->first();
            if ($token->user->level == 2) {
                if ($user) {
                    Auth::login($user);
                    $pend = Pendaftaran::whereExists(function ($db) {
                        $db->select("*")
                            ->from("mahasiswas")
                            ->whereRaw(
                                "mahasiswas.id = pendaftarans.mahasiswa_id"
                            )
                            ->where("mahasiswas.user_id", Auth::id());
                    })
                        ->whereExists(function ($db) {
                            $db->select("*")
                                ->from("subkpms")
                                ->whereRaw(
                                    "subkpms.id = pendaftarans.subkpm_id"
                                )
                                ->whereExists(function ($db) {
                                    $db->select("*")
                                        ->from("kpms")
                                        ->whereRaw(
                                            "kpms.id = subkpms.kpm_id"
                                        )
                                        ->whereExists(function ($db) {
                                            $db->select("*")
                                                ->from("tahun_akademiks")
                                                ->whereRaw(
                                                    "tahun_akademiks.id = kpms.tahun_akademik_id"
                                                )
                                                ->where(
                                                    "tahun_akademiks.status",
                                                    1
                                                );
                                        });
                                });
                        })
                        ->first();

                    session([
                        "token_api" => $token, // token hasil login api
                        "register" => true, // false artinya tidak ada di database
                        "status" => $pend ? $pend->status : 0, // status pendaftaran
                        'user' => $user,
                        "level" => $user->access[0], // level user
                    ]);

                    if ($pend && in_array($pend->status, [1, 3])) {
                        return Redirect::to("mhs/reg/final");
                    } else {
                        return Redirect::to("mhs/reg");
                    }
                } else {
                    // data tidak ada
                    $ta = TahunAkademik::where("status", 1)->first();
                    if ($ta && count($ta->kpm)) {
                        session([
                            "token_api" => $token, // token hasil login api
                            "register" => false, // false artinya tidak ada di database
                            "status" => 0, // status pendaftaran
                            "level" => 2, // level user
                        ]);
                        return Redirect::to("mhs/unreg");
                    } else {
                        return Redirect::to("signin")
                            ->withErrors(
                                "Mohon maaf, saat ini belum ada pendaftaran KPM yang tersedia",
                                "login"
                            )
                            ->withInput();
                    }
                }
            } else if ($token->user->level == 1) {
                session([
                    "token_api" => $token, // token hasil login api
                    "level" => $user->access[0], // level user
                ]);
                if ($user) {
                    Auth::login($user);
                    session()->put('user', $user);
                    session()->put('register', true);
                    return Redirect::to(route('dpl.dashboard'));
                } else {
                    session()->put('register', false);
                    return Redirect::to(route('dpl.reg.profil'));
                }
            }
        } else {
            if (
                Auth::attempt([
                    "email" => $request->id_login,
                    "password" => $request->password,
                ]) ||
                Auth::attempt([
                    "username" => $request->id_login,
                    "password" => $request->password,
                ])
            ) {
                $user = Auth::user();
                session([
                    'user' => $user,
                    "level" => $user->access[0], // level user
                ]);
                return Redirect::to(route('dashboard'));
            } else {
                return Redirect::to("signin")
                    ->withErrors($result, "login")
                    ->withInput();
            }
        }
    }

    public function logout(Request $request)
    {
        \IainApi::get("api/auth/logout");
        Auth::logout();
        session()->flush();

        if ($request->json == 1) {
            return response()->json(true);
        } else {
            return Redirect::to("signin");
        }
    }
}
