<?php

use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
    return view('welcome', ['location' => (new App\Http\Controllers\CityController())->getUserLocation(),
        'cities' => \App\Models\City::orderBy('name')->get(),
        'feedbacks' => \App\Models\Feedback::all()]);
});

Route::get('feedback/create', [FeedbackController::class, 'gotoCreate'])
    ->middleware('auth', 'verified')->name('gotoFeedbackCreate');
Route::get('feedback/change', [FeedbackController::class, 'gotoChange'])
    ->middleware('auth', 'verified')->name('gotoFeedbackChange');
Route::get('user/feedbacks', [FeedbackController::class, 'gotoUserFeedbacks'])
    ->middleware('auth', 'verified')->name('gotoUserFeedbacks');

Route::get('feedback/checkCity', [CityController::class, 'checkCity'])->name('checkCity');
Route::post('feedback/addNewCity', [CityController::class, 'addNewCity'])->name('addNewCity');
Route::post('feedback/created', [FeedbackController::class, 'sendFeedback'])->name('sendFeedback');


Route::get('getUserLocation', [CityController::class, 'getUserLocation']);
Route::get('reloadCaptcha', [CaptchaController::class, 'reloadCaptcha']);

Route::get('getCityFeedbacks', [FeedbackController::class, 'getCityFeedbacks']);
Route::get('getSession', [FeedbackController::class, 'getSession']);

Auth::routes();
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
