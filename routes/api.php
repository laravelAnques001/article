<?php

use App\Http\Controllers\Api\AdvertiseController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\WalletController;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('otp-generate', [AuthController::class, 'otpGenerate']);
Route::post('otp-verify', [AuthController::class, 'otpVerify']);
// Route::post('forget-password', [AuthController::class, 'forgetPassword']);

Route::get('article', [ArticleController::class, 'index']);
Route::get('article/{article}', [ArticleController::class, 'show']);
Route::post('impression-click-article', [AdvertiseController::class, 'impressionClick']);
// Route::get('trending-article', [ArticleController::class, 'trendingArticle']);
Route::get('topics', [ArticleController::class, 'topics']);
Route::get('article-notification', [ArticleController::class, 'articleNotification']);
Route::post('advertise-get', [AdvertiseController::class, 'getAdvertise']);
Route::post('article-like-share', [ArticleController::class, 'likeShare']);

Route::middleware(['auth:api'])->Group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('profile-update', [AuthController::class, 'profileUpdate']);

    // categories
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);
    Route::post('user-category', [CategoryController::class, 'userCategory']);

    // article
    // Route::get('my-article', [ArticleController::class, 'myArticle']);
    // Route::get('bookmark-article', [ArticleController::class, 'bookmarkArticle']);
    Route::get('user-article', [ArticleController::class, 'userArticle']);

    Route::post('article', [ArticleController::class, 'store']);
    Route::post('edit-article/{article}', [ArticleController::class, 'update']);
    Route::delete('article/{article}', [ArticleController::class, 'destroy']);
    Route::post('user/article-like-share', [ArticleController::class, 'likeShareUser']);
    // Route::apiResource('article', ArticleController::class);

    // My Article
    // Route::get('my-article', [ArticleController::class, 'myArticle']);

    // Polls List
    // Route::get('polls', [PollsController::class, 'index']);

    // advertise
    Route::get('advertise', [AdvertiseController::class, 'index']);
    Route::post('advertise', [AdvertiseController::class, 'store']);
    Route::post('edit-advertise/{advertise}', [AdvertiseController::class, 'update']);
    Route::delete('advertise/{advertise}', [AdvertiseController::class, 'destroy']);
    // Route::get('advertise/{advertise}', [AdvertiseController::class, 'show']);

    // Route::get('setting/{key}', [AuthController::class, 'setting']);

    Route::get('wallet', [WalletController::class, 'index']);
    Route::post('wallet', [WalletController::class, 'store']);

});
