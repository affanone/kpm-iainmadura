<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;

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

<<<<<<< HEAD
Route::get("/signin", [AuthenticationController::class, "index"])->name(
    "login_page"
);
Route::post("/signin", [AuthenticationController::class, "login"])->name(
    "login_auth"
);
=======
Route::get('/signin', [AuthenticationController::class, 'index'])->name('login_page');

Route::group(["prefix" => "dashboard"], function () {
    Route::get("/", [DashboardController::class, 'index']);
});
>>>>>>> d7721fb5cd00363b14dfb82b0a91d4dddbb4502f
