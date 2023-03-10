<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

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
    return Redirect::to(route('login_page'));
});

Route::group(
    ["prefix" => "super", "middleware" => ["auth", "revalidate"]],
    function () {
        Route::get("/", [\App\Http\Controllers\Superadmin\DashboardController::class, "index"])->name("dashboard");
        Route::get("/user_category", [\App\Http\Controllers\Superadmin\UserCategoryController::class, "index"])->name("user.category");
        Route::get("/user", [\App\Http\Controllers\Superadmin\UserController::class, "index"])->name("user");
        Route::get("/master", [\App\Http\Controllers\Superadmin\MasterController::class, "index"]);
        Route::get("/syarat", [\App\Http\Controllers\Superadmin\PersyaratanController::class, "index"])->name("persyaratan");

        Route::get("/tahun_akademik", [\App\Http\Controllers\Superadmin\TahunAkademikController::class, "index"])->name("tahun.akademik");
        Route::post("/tahun_akademik", [\App\Http\Controllers\Superadmin\TahunAkademikController::class, "store"])->name("tahun_akademik.post");
        Route::post("/tahun_akademik/data", [\App\Http\Controllers\Superadmin\TahunAkademikController::class, "show"])->name("tahun_akademik.data");
        Route::get("/tahun_akademik/{id}", [\App\Http\Controllers\Superadmin\TahunAkademikController::class, "edit"])->name("tahun_akademik.edit");
        Route::put("/tahun_akademik", [\App\Http\Controllers\Superadmin\TahunAkademikController::class, "update"])->name("tahun_akademik.update");
        Route::delete("/tahun_akademik", [\App\Http\Controllers\Superadmin\TahunAkademikController::class, "destroy"])->name("tahun_akademik.delete");

        Route::get("/kpm", [\App\Http\Controllers\Superadmin\JenisKPMController::class, "index"])->name("jenis_kpm");
        Route::post("/kpm", [\App\Http\Controllers\Superadmin\JenisKPMController::class, "store"])->name("jenis_kpm.post");
        Route::post("/kpm/data", [\App\Http\Controllers\Superadmin\JenisKPMController::class, "show"])->name("jenis_kpm.data");
        Route::get("/kpm/{id}", [\App\Http\Controllers\Superadmin\JenisKPMController::class, "edit"])->name("jenis_kpm.edit");
        Route::put("/kpm", [\App\Http\Controllers\Superadmin\JenisKPMController::class, "update"])->name("jenis_kpm.update");
        Route::delete("/kpm", [\App\Http\Controllers\Superadmin\JenisKPMController::class, "destroy"])->name("jenis_kpm.delete");

        Route::get("/data_kpm", [\App\Http\Controllers\Superadmin\DataKPMController::class, "index"])->name("data_kpm");
        Route::post("/data_kpm", [\App\Http\Controllers\Superadmin\DataKPMController::class, "store"])->name("data_kpm.post");
        Route::post("/data_kpm/data", [\App\Http\Controllers\Superadmin\DataKPMController::class, "show"])->name("data_kpm.data");
        Route::get("/data_kpm/{id}", [\App\Http\Controllers\Superadmin\DataKPMController::class, "edit"])->name("data_kpm.edit");
        Route::put("/data_kpm", [\App\Http\Controllers\Superadmin\DataKPMController::class, "update"])->name("data_kpm.update");
        Route::delete("/data_kpm", [\App\Http\Controllers\Superadmin\DataKPMController::class, "destroy"])->name("data_kpm.delete");

        Route::get("/dpl", [\App\Http\Controllers\Superadmin\DplController::class, "index"])->name("dpl");
        Route::post("/dpl/data", [\App\Http\Controllers\Superadmin\DplController::class, "show"])->name("dpl.data");
        Route::get("/dpl/{id}", [\App\Http\Controllers\Superadmin\DplController::class, "edit"])->name("dpl.edit");
        Route::put("/dpl", [\App\Http\Controllers\Superadmin\DplController::class, "update"])->name("dpl.update");
        Route::delete("/dpl", [\App\Http\Controllers\Superadmin\DplController::class, "destroy"])->name("dpl.delete");

        Route::get("/admin_fakultas", [\App\Http\Controllers\Superadmin\AdminFakultasController::class, "index"])->name("admin_fakultas");
        Route::post("/admin_fakultas", [\App\Http\Controllers\Superadmin\AdminFakultasController::class, "store"])->name("admin_fakultas.post");
        Route::post("/admin_fakultas/data", [\App\Http\Controllers\Superadmin\AdminFakultasController::class, "show"])->name("admin_fakultas.data");
        Route::get("/admin_fakultas/{id}", [\App\Http\Controllers\Superadmin\AdminFakultasController::class, "edit"])->name("admin_fakultas.edit");
        Route::put("/admin_fakultas", [\App\Http\Controllers\Superadmin\AdminFakultasController::class, "update"])->name("admin_fakultas.update");
        Route::delete("/admin_fakultas", [\App\Http\Controllers\Superadmin\AdminFakultasController::class, "destroy"])->name("admin_fakultas.delete");

        Route::get("/laporan/kpm", [\App\Http\Controllers\Superadmin\LaporanController::class, "kpm"])->name("laporan.kpm");
        Route::get("/laporan/kpm/{id}", [\App\Http\Controllers\Superadmin\LaporanController::class, "kpm_detail"])->name("laporan.kpm.detail");
    }
);

Route::group(
    ["prefix" => "mhs", "middleware" => ["auth", "akses_mahasiswa"]],
    function () {
        Route::get("/", [
            \App\Http\Controllers\Mhs\DashboardController::class,
            "index",
        ]);
    }
);

Route::group(["prefix" => "fakultas", "middleware" => ["level_fakultas"]], function () {
    Route::get("/dashboard", [
        \App\Http\Controllers\Fakultas\DashboardController::class,
        "index",
    ])->name("fakultas.dashboard");

    Route::get("/posko", [
        \App\Http\Controllers\Fakultas\PoskoController::class,
        "index",
    ])->name("fakultas.posko");
    Route::post("/posko", [
        \App\Http\Controllers\Fakultas\PoskoController::class,
        "store",
    ])->name("fakultas.posko.store");
    Route::get("/posko/{id}", [
        \App\Http\Controllers\Fakultas\PoskoController::class,
        "show",
    ])->name("fakultas.posko.edit");
    Route::put("/posko/{id}", [
        \App\Http\Controllers\Fakultas\PoskoController::class,
        "update",
    ])->name("fakultas.posko.update");
    Route::delete("/posko/{id}", [
        \App\Http\Controllers\Fakultas\PoskoController::class,
        "destroy",
    ])->name("fakultas.posko.delete");

    Route::get("/posko/penempatan_peserta/{posko}", [\App\Http\Controllers\Fakultas\PenempatanPesertaController::class, "index"])->name("fakultas.posko.penempatan");
    Route::post("/posko/penempatan_peserta", [\App\Http\Controllers\Fakultas\PenempatanPesertaController::class, "store"])->name("fakultas.posko.penempatan.post");
    Route::delete("/posko/penempatan_peserta/delete", [\App\Http\Controllers\Fakultas\PenempatanPesertaController::class, "destroy"])->name("fakultas.posko.penempatan.delete");

    Route::get("/", function () {
        return Redirect::to(route("fakultas.dashboard"));
    })->name("fakultas");
});

Route::group(["prefix" => "dpl", "middleware" => ["level_dpl"]], function () {
    Route::group(["prefix" => "reg", "middleware" => ['dpl_unregister']], function () {
        Route::get("/profil", [
            \App\Http\Controllers\Reg\DplController::class,
            "profil",
        ])->name("dpl.reg.profil");

        Route::post("/profil", [
            \App\Http\Controllers\Reg\DplController::class,
            "register",
        ])->name("dpl.reg.profil.post");

        Route::get("/", function () {
            return Redirect::to(route("dpl.reg.profil"));
        });
    });

    Route::group(["prefix" => "/", "middleware" => ['dpl_register']], function () {
        Route::get("/dashboard", [
            \App\Http\Controllers\Dpl\DashboardController::class,
            "index",
        ])->name("dpl.dashboard");

        Route::get("/kpm", [
            \App\Http\Controllers\Dpl\KpmController::class,
            "index",
        ])->name("dpl.kpm");

        Route::get("/kpm/{id}", [
            \App\Http\Controllers\Dpl\KpmController::class,
            "show",
        ])->name("dpl.kpm.detail");

        Route::get("/nilai", [
            \App\Http\Controllers\Dpl\NilaiController::class,
            "index",
        ])->name("dpl.nilai");

        Route::post("/nilai", [
            \App\Http\Controllers\Dpl\NilaiController::class,
            "store",
        ])->name("dpl.nilai.post");

        Route::get("/mahasiswa", [\App\Http\Controllers\Dpl\DashboardController::class, "show"])->name("dpl.mahasiswa");
        Route::post("/mahasiswa/data", [\App\Http\Controllers\Dpl\DashboardController::class, "data"])->name("dpl.mahasiswa.data");

        Route::get("/", function () {
            return Redirect::to(route("dpl.reg.profil"));
        });
    });
});

Route::group(["prefix" => "mhs", "middleware" => ["level_mhs"]], function () {
    Route::group(
        ["prefix" => "reg", "middleware" => ["mhs_register"]],
        function () {
            Route::post("/register", [
                \App\Http\Controllers\Reg\RegisterController::class,
                "update_profil",
            ])->name("mhs.reg.profil");

            Route::get("/profil", [
                \App\Http\Controllers\Reg\RegisterController::class,
                "profil",
            ])->name("mhs.reg.profil.get");

            Route::get("/kpm", [
                \App\Http\Controllers\Reg\RegisterController::class,
                "kpm",
            ])->name("mhs.reg.kpm.get");

            Route::post("/kpm", [
                \App\Http\Controllers\Reg\RegisterController::class,
                "update_kpm",
            ])->name("mhs.reg.kpm");

            Route::get("/syarat", [
                \App\Http\Controllers\Reg\RegisterController::class,
                "syarat",
            ])->name("mhs.reg.syarat.get");

            Route::post("/syarat", [
                \App\Http\Controllers\Reg\RegisterController::class,
                "upload_syarat",
            ])->name("mhs.reg.syarat");

            Route::get("/final", [
                \App\Http\Controllers\Reg\RegisterController::class,
                "finalisasi",
            ])->name("mhs.reg.final.get");

            Route::post("/final", [
                \App\Http\Controllers\Reg\RegisterController::class,
                "verifikasi_dan_finalisasi",
            ])->name("mhs.reg.final");

            Route::get("/", function () {
                return Redirect::to(route("mhs.reg.profil.get"));
            });
        }
    );

    Route::group(
        ["prefix" => "unreg", "middleware" => ["mhs_unregister"]],
        function () {
            Route::get("/", [
                \App\Http\Controllers\Reg\CheckController::class,
                "index",
            ])->name("mhs.unreg.index");

            Route::post("/aktif", [
                \App\Http\Controllers\Reg\CheckController::class,
                "check_aktif",
            ])->name("mhs.unreg.aktif");

            Route::post("/sks", [
                \App\Http\Controllers\Reg\CheckController::class,
                "check_sks",
            ])->name("mhs.unreg.sks");

            Route::post("/mk", [
                \App\Http\Controllers\Reg\CheckController::class,
                "check_mk",
            ])->name("mhs.unreg.mk");

            Route::get("/valid", [
                \App\Http\Controllers\Reg\CheckController::class,
                "valid",
            ])->name("mhs.unreg.valid");

            Route::post("/register", [
                \App\Http\Controllers\Reg\RegisterController::class,
                "registrasi",
            ])->name("mhs.unreg.register");
        }
    );

    Route::group(
        ["prefix" => "/", "middleware" => ["mhs_dashboard"]],
        function () {
            Route::get("/dashboard", [
                \App\Http\Controllers\Mhs\DashboardController::class,
                "index",
            ])->name("mhs.dashboard");

            Route::get("/", function () {
                return Redirect::to(route("mhs.reg.profil.get"));
            });
        }
    );
});

Route::get("/logout", [AuthenticationController::class, "logout"]);
Route::get("/signin", [AuthenticationController::class, "index"])
    ->name("login_page")
    ->middleware("is_login");
Route::post("/signin", [AuthenticationController::class, "login"])->name(
    "login_auth"
);
Route::get("attachment/{folder}/{file}/{extension}", function (
    $folder,
    $file,
    $extension
) {
    $filename = $_GET["filename"] ?? $file;
    $ext = $extension ? "." . $extension : "";
    $file = $file . $ext;
    $path = storage_path("app/" . $folder . "/" . $file);

    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    if ($filename) {
        $response->header(
            "Content-disposition",
            'attachment; filename="' . $filename . $ext . '"'
        );
    }

    $arr_ext = ["pdf", "png", "gif", "jpeg", "jpg"];

    if (in_array($_GET["type"] ?? "", $arr_ext)) {
        return response()->file($path);
    }

    return $response;
});

// TESTING

Route::get("/password/{pass}", function ($pass) {
    return Hash::make($pass);
});

Route::get("/dummi/register", [
    \App\Http\Controllers\Reg\RegisterController::class,
    "dummy_mahasiswa",
]);

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
