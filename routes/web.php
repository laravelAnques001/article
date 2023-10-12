<?php

use App\Http\Controllers\Web\AdvertiseController;
use App\Http\Controllers\Web\ArticleController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\BusinessController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\DashBoardController;
use App\Http\Controllers\Web\EnquiryController;
use App\Http\Controllers\Web\PollsController;
use App\Http\Controllers\Web\ServiceApplyController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\SettingController;
use App\Http\Controllers\Web\SubscriptionPlanController;
use App\Http\Controllers\Web\UserController;
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

Route::get('article-view/{id}', [ArticleController::class, 'articleView']);

Route::get('business-view/{id}', [BusinessController::class, 'businessView'])->name('businessView');

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
    Route::resource('users', UserController::class);
    Route::resource('subscriptionPlan', SubscriptionPlanController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('business', BusinessController::class);

    Route::get('article/{id}/{status}', [ArticleController::class, 'status'])->name('admin.article.status');
    Route::get('services/{id}/{status}', [ServiceController::class, 'status'])->name('admin.services.status');
    Route::get('subscriptionPlan/{id}/{status}', [SubscriptionPlanController::class, 'status'])->name('admin.subscriptionPlan.status');
    Route::get('business/{id}/{status}', [BusinessController::class, 'status'])->name('admin.business.status');

    Route::get('advertise/ad_status/{id}/{ad_status}', [AdvertiseController::class, 'adStatus'])->name('admin.advertise.ad_status');
    Route::get('advertise/status/{id}/{status}', [AdvertiseController::class, 'status'])->name('admin.advertise.status');

    Route::post('category/getData', [CategoryController::class, 'getCategoryData'])->name('admin.category.getData');
    Route::post('article/getData', [ArticleController::class, 'getArticleData'])->name('admin.article.getData');
    Route::post('advertise/getData', [AdvertiseController::class, 'getAdvertiseData'])->name('admin.advertise.getData');
    Route::post('wallet/getData', [WalletController::class, 'getWalletData'])->name('admin.wallet.getData');
    Route::post('polls/getData', [PollsController::class, 'getPollsData'])->name('admin.polls.getData');
    Route::post('setting/getData', [SettingController::class, 'getSettingData'])->name('admin.setting.getData');
    Route::post('users/getData', [UserController::class, 'getUserData'])->name('admin.users.getData');
    Route::post('subscriptionPlan/getData', [SubscriptionPlanController::class, 'getData'])->name('admin.subscriptionPlan.getData');
    Route::post('services/getData', [ServiceController::class, 'getData'])->name('admin.services.getData');
    Route::post('business/getData', [BusinessController::class, 'getData'])->name('admin.business.getData');

    // Enquiry
    Route::post('enquiry/getData', [EnquiryController::class, 'getData'])->name('admin.enquiry.getData');
    Route::get('enquiry', [EnquiryController::class, 'index'])->name('enquiry.index');
    Route::delete('enquiry/{enquiry}', [EnquiryController::class, 'destroy'])->name('enquiry.destroy');

    // Digital Service Apply
    Route::get('digital-service-apply', [ServiceApplyController::class, 'index'])->name('digitalServiceApply.index');
    Route::get('digital-service-apply/{enquiry}', [ServiceApplyController::class, 'show'])->name('digitalServiceApply.show');
    Route::delete('digital-service-apply/{enquiry}', [ServiceApplyController::class, 'destroy'])->name('digitalServiceApply.destroy');
    Route::post('digital-service-apply/getData', [ServiceApplyController::class, 'getData'])->name('admin.digitalServiceApply.getData');

});
