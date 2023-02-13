<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PersyaratanController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get("/", function () {
    return view("welcome");
});

Route::group(["prefix" => "dashboard"], function () {
    Route::get("/", [DashboardController::class, "index"])->name("dashboard");
    Route::get("/user_category", [
        UserCategoryController::class,
        "index",
    ])->name("user.category");
    Route::get("/user", [UserController::class, "index"])->name("user");
    Route::get("/master", [MasterController::class, "index"]);
    Route::get("/syarat", [PersyaratanController::class, "index"])->name(
        "persyaratan"
    );
    Route::get("pendaftaran", [PendaftaranController::class, "index"])->name(
        "pendaftaran.kpm"
    );
});

Route::group(
    ["prefix" => "mhs", "middleware" => ["auth", "akses_mahasiswa"]],
    function () {
        Route::get("/", [
            \App\Http\Controllers\Mhs\DashboardController::class,
            "index",
        ]);
    }
);

Route::group(
    ["prefix" => "reg", "middleware" => ["mhs_register"]],
    function () {
        Route::get("/profil", [
            \App\Http\Controllers\Reg\RegisterController::class,
            "profil",
        ])->name("reg_profil");

        Route::get("/kpm", [
            \App\Http\Controllers\Reg\RegisterController::class,
            "kpm",
        ])->name("reg_kpm");

        // Route::get("/kpm", [
        //     \App\Http\Controllers\Reg\RegisterController::class,
        //     "kpm",
        // ])->name("reg_syarat");

        // Route::get("/kpm", [
        //     \App\Http\Controllers\Reg\RegisterController::class,
        //     "kpm",
        // ])->name("reg_final");
    }
);

Route::group(
    ["prefix" => "unreg", "middleware" => ["mhs_unregister"]],
    function () {
        Route::get("/", [
            \App\Http\Controllers\Reg\CheckController::class,
            "index",
        ]);

        Route::post("/aktif", [
            \App\Http\Controllers\Reg\CheckController::class,
            "check_aktif",
        ]);

        Route::post("/sks", [
            \App\Http\Controllers\Reg\CheckController::class,
            "check_sks",
        ]);

        Route::post("/mk", [
            \App\Http\Controllers\Reg\CheckController::class,
            "check_mk",
        ]);

        Route::get("/valid", [
            \App\Http\Controllers\Reg\CheckController::class,
            "valid",
        ]);

        Route::post("/register", [
            \App\Http\Controllers\Reg\RegisterController::class,
            "registrasi",
        ])->name("register");
    }
);
Route::get("/logout", [AuthenticationController::class, "logout"]);
Route::get("/signin", [AuthenticationController::class, "index"])
    ->name("login_page")
    ->middleware("is_login");
Route::post("/signin", [AuthenticationController::class, "login"])->name(
    "login_auth"
);

Route::get("/password", function () {
    return Hash::make("19380011030");
});

Route::get("/dummi/ta", function () {
    return "a";
    $kpm = [];
    array_push($kpm, [
        "id" => "krs",
        "name" => "krs",
        "deskripsi" => "Harap Upload KRS terbaru anda",
        "validator" => "required",
        "format" => [
            "pdf" => [
                "max" => 5000000, // byte
                "min" => 0, // infinity
            ],
            "jpg" => [
                "max" => 1000000, // byte
                "min" => 0, // infinity
            ],
        ],
    ]);
    array_push($kpm, [
        "id" => "rekom",
        "name" => "rekom",
        "deskripsi" => "Harap uload rekomendasi dari dekan",
        "validator" => "required",
        "format" => [
            "pdf" => [
                "max" => 5000000, // byte
                "min" => 0, // infinity
            ],
            "jpg" => [
                "max" => 1000000, // byte
                "min" => 0, // infinity
            ],
        ],
    ]);
    $i = new \App\Models\Subkpm();
    $i->nama = "KPM Fakultas";
    $i->config_upload = json_encode($kpm);
    $i->deskripsi =
        "Beberapa persyaratan yang harus anda upload untuk mendaftar KPM Fakultas";
    $i->kpm_id = "057513a7-d145-4a94-a009-8b492dcca624";
    $i->save();

    $i = new \App\Models\Subkpm();
    $i->nama = "KPM Institur";
    $i->config_upload = json_encode($kpm);
    $i->deskripsi =
        "Beberapa persyaratan yang harus anda upload untuk mendaftar KPM Institur";
    $i->kpm_id = "057513a7-d145-4a94-a009-8b492dcca624";
    $i->save();
});
