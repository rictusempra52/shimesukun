<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

// 認証関連のルート
Auth::routes();

// 書類管理
Route::middleware(['auth'])->group(function () {
    // ダッシュボード
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // 書類管理
    Route::resource('documents', DocumentController::class);
});
