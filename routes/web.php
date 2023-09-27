<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('pages.app.dashboard-siakad', ['type_menu' => '']);
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('pages.app.dashboard-siakad', ['type_menu' => '']);
    });
    Route::resource('/user/siswa', UserController::class);
    Route::resource('/user/tutor', TutorController::class);
    Route::resource('/user/karyawan', KaryawanController::class);
    Route::resource('/user/admin', AdminController::class);
});
