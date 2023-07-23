<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Feedback\FeedbackController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::name('api.')->group(function () {
    Route::resource('feedbacks', FeedbackController::class)->only(['store', 'show']);
});
