<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

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

// このルートは初期ページ表示用です。
Route::get('/application', [ChatController::class, 'showApplicationForm'])->name('application.form');

// このルートはフォームの送信とファイルアップロードの両方の機能を兼ねるようになります。
Route::post('/generate-application', [ChatController::class, 'generateApplication'])->name('application.generate');

Route::get('/', function () {
    return view('welcome');
});
