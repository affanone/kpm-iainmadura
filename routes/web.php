<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasterController;
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
    Route::get("/user_category", [UserCategoryController::class, "index"])->name("user.category");
    Route::get("/user", [UserController::class, "index"])->name("user");
    Route::get("/master", [MasterController::class, "index"]);
    Route::get("/loader", [DashboardController::class, "create"]);
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

Route::get("/signin", [AuthenticationController::class, "index"])->name(
    "login_page"
);
Route::post("/signin", [AuthenticationController::class, "login"])->name(
    "login_auth"
);

Route::get("/password", function () {
    return Hash::make("19380011030");
});