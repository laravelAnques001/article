<?php

use App\Http\Controllers\Web\AdvertiseController;
use App\Http\Controllers\Web\ArticleController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\DashBoardController;
use App\Http\Controllers\Web\PollsController;
use App\Http\Controllers\Web\SettingController;
use App\Http\Controllers\Web\WalletController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
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

//Clear all Cache facade value:
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('optimize');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    return '<h1>Cache cleared</h1>';
});

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('privacy', function () {
    return view('privacy');
});

Route::get('term-condition', function () {
    return view('termCondition');
});

Route::get('article-view/{id}', [ArticleController::class,'articleView']);

Route::group(['middleware' => 'auth'], function () {

    Route::get('dashboard', [DashBoardController::class, 'dashboard'])->name('dashboard');

    Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('resetpassword');
    Route::post('/reset-password/store', [AuthController::class, 'resetPasswordStore'])->name('resetpassword.store');

    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('profile-update', [AuthController::class, 'profileUpdate'])->name('profile.update');

    Route::resource('category', CategoryController::class);
    Route::resource('article', ArticleController::class);
    Route::resource('advertise', AdvertiseController::class);
    Route::resource('wallet', WalletController::class);
    Route::resource('polls', PollsController::class);
    Route::resource('setting', SettingController::class);

    Route::get('article/{id}/{status}', [ArticleController::class, 'status'])->name('admin.article.status');
    Route::get('advertise/{id}/{status}', [AdvertiseController::class, 'status'])->name('admin.advertise.status');

    Route::post('category/getData', [CategoryController::class, 'getCategoryData'])->name('admin.category.getData');
    Route::post('article/getData', [ArticleController::class, 'getArticleData'])->name('admin.article.getData');
    Route::post('advertise/getData', [AdvertiseController::class, 'getAdvertiseData'])->name('admin.advertise.getData');
    Route::post('wallet/getData', [WalletController::class, 'getWalletData'])->name('admin.wallet.getData');
    Route::post('polls/getData', [PollsController::class, 'getPollsData'])->name('admin.polls.getData');
    Route::post('setting/getData', [SettingController::class, 'getSettingData'])->name('admin.setting.getData');

});
