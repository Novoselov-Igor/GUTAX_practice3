<?php

use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\FeedbackController;
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

Route::group(['middleware' => 'auth'],function(){
    Route::get('feedback/create', [FeedbackController::class, 'gotoCreate'])->name('gotoFeedbackCreate');
});

Route::get('getUserLocation', [CityController::class, 'getUserLocation']);
Route::get('reloadCaptcha', [CaptchaController::class, 'reloadCaptcha']);

Route::get('getCityFeedbacks', [FeedbackController::class, 'getCityFeedbacks']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
