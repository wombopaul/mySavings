<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\CreateAccountController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\User\ChangePasswordController;
use App\Http\Controllers\Subscribers\SubscriberCategoryController;
use App\Http\Controllers\Subscribers\SubscriberController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');


Route::prefix('v1')->group(static function(){

    Route::prefix('users')->name('auth.')->group(static function(){
        Route::post('/createAccount', [CreateAccountController::class, 'createAccount'])->name('createAccount');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/forgotPassword', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forgotPassword');
        Route::post('/resetPassword', [ResetPasswordController::class, 'reset'])->name('resetPassword');
});

    Route::middleware('auth:sanctum')->group(static function () {
        Route::prefix('user')->name('user.')->group(static function () {
            Route::get('/profile', [UserProfileController::class, 'show'])->name('show');
            Route::post('/profilePicture', [UserProfileController::class, 'profilePicture'])->name('profilePicture');
            Route::patch('/changePassword', [ChangePasswordController::class, 'changePassword'])->name('changePassword');
            Route::post('/logOut', [UserProfileController::class, 'logOut'])->name('logOut');
        });

        Route::prefix('subscriberCategories')->name('category.')->group(static function(){
            Route::get('/',[SubscriberCategoryController::class, 'index'])->name('index');
            Route::post('/',[SubscriberCategoryController::class, 'store'])->name('store');
            Route::get('/{category}',[SubscriberCategoryController::class, 'show'])->name('show');
            Route::patch('/{category}',[SubscriberCategoryController::class, 'update'])->name('update');
            Route::delete('/{category}',[SubscriberCategoryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('subscribers')->name('subscriber.')->group(static function(){
            Route::get('/', [SubscriberController::class, 'index'])->name('index');
            Route::get('/{subscriber}', [SubscriberController::class, 'show'])->name('show');
            Route::post('/', [SubscriberController::class, 'subscriberSubscription'])->name('subscriberSubscription');
            Route::post('/update-details', [SubscriberController::class, 'updateDetails'])->name('updateDetails');
        });
    });

});