<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ThumbsUpController;
use App\Http\Controllers\ThumbsUpAnswerController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\SearchController;

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
Route::group(['middleware' => 'auth'], function () {
    Route::post('answer/{answer}/thumbsup', [ThumbsUpAnswerController::class, 'store'])->name('thumbsupanswer');
    Route::post('answer/{answer}/unthumbsup', [ThumbsUpAnswerController::class, 'destroy'])->name('unthumbsupanswer');

    Route::resource('answer', AnswerController::class);

    Route::get('/question/search/input', [SearchController::class, 'create'])->name('search.input');
    Route::get('/question/search/result', [SearchController::class, 'index'])->name('search.result');

    Route::get('user/{user}', [FollowController::class, 'show'])->name('follow.show');

    Route::post('user/{user}/follow', [FollowController::class, 'store'])->name('follow');
    Route::post('user/{user}/unfollow', [FollowController::class, 'destroy'])->name('unfollow');

    Route::post('question/{question}/thumbsup', [ThumbsUpController::class, 'store'])->name('thumbsup');
    Route::post('question/{question}/unthumbsup', [ThumbsUpController::class, 'destroy'])->name('unthumbsup');

    Route::get('/question/mypage', [QuestionController::class, 'mydata'])->name('question.mypage');
    Route::resource('question', QuestionController::class);
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
