<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\QuizController;
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

Route::get('/', [QuizController::class, 'homePage'])->name('home');
Route::post('/quiz', [QuizController::class, 'getQuiz'])->name('quiz');
Route::post('/result', [QuizController::class, 'getResult'])->name('result');

Auth::routes();

