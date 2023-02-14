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
use App\Http\Controllers\Superadmin\TahunAkademikController;
use Illuminate\Support\Facades\Redirect;

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
    Route::get("/tahun_akademik", [TahunAkademikController::class, "index"])->name("tahun.akademik");
    Route::post("/tahun_akademik", [TahunAkademikController::class, "store"])->name("tahun_akademik.post");
    Route::post("/tahun_akademik/data", [TahunAkademikController::class, "show"])->name("tahun_akademik.data");
    Route::get("/tahun_akademik/{id}", [TahunAkademikController::class, "edit"])->name("tahun_akademik.edit");
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
        Route::post("/register", [
            \App\Http\Controllers\Reg\RegisterController::class,
            "update_profil",
        ])->name("reg_update_profil");

        Route::get("/profil", [
            \App\Http\Controllers\Reg\RegisterController::class,
            "profil",
        ])->name("reg_profil");

        Route::get("/kpm", [
            \App\Http\Controllers\Reg\RegisterController::class,
            "kpm",
        ])->name("reg_kpm");

        Route::post("/kpm", [
            \App\Http\Controllers\Reg\RegisterController::class,
            "update_kpm",
        ])->name("reg_update_kpm");

        Route::get("/syarat", [
            \App\Http\Controllers\Reg\RegisterController::class,
            "syarat",
        ])->name("reg_syarat");

        Route::post("/syarat", [
            \App\Http\Controllers\Reg\RegisterController::class,
            "upload_syarat",
        ])->name("reg_upload_syarat");

        Route::get("/", function () {
            Redirect::to('reg/profil');
        });
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
