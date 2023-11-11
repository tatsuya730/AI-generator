<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PaymentController;


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

// このルートはフォームの送信に使用されます。
Route::post('/generate-application', [ChatController::class, 'generateApplication'])->name('application.generate');

// ファイルアップロードのルートを追加
Route::post('/file-upload', [ChatController::class, 'uploadFile'])->name('file.upload');

Route::get('/', [PostController::class, 'index'])
    ->name('root');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('posts', PostController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');

Route::resource('posts', PostController::class)
    ->only(['show', 'index']);

Route::get('/learn-about-subsidy', function () {
    // ここで補助金についてのビューを返すか、コントローラメソッドを指定します。
    return view('your-view-name');
})->name('learn.subsidy');

Route::get('/pricing', function () {
    // 'pricing' ビューを返すコードをここに記述します。
    return view('pricing');
})->name('pricing');

Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/create', [PaymentController::class, 'create'])->name('create');
    Route::post('/store', [PaymentController::class, 'store'])->name('store');
});

require __DIR__.'/auth.php';
