<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ScoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::middleware(['admin'])->group(function(){
    Route::post('/quiz', [QuizController::class, 'addQuiz']); // param : quiz
    Route::put('/quiz/{quizId}', [QuizController::class, 'editQuiz']); // param : quiz
    Route::delete('/quiz/{quizId}', [QuizController::class, 'removeQuiz']);

    Route::post('/quiz/{quizId}/publish', [QuizController::class, 'publishQuiz']);
    Route::post('/quiz/{quizId}/unpublish', [QuizController::class, 'unpublishQuiz']);

    Route::get('/score', [ScoreController::class, 'getScores']);

    Route::get('/user/{userId}', [AuthController::class, 'userProfile']);
});

Route::get('/quiz', [QuizController::class, 'getQuizzes'])->name('home');
Route::get('/quiz/{quizId}', [QuizController::class, 'getQuiz']);
Route::get('/quiz/{quizId}/questions', [QuizController::class, 'getQuestions']);
Route::get('/question/{questionId}/choices', [QuestionController::class, 'getChoices']);

Route::post('/score', [QuizController::class, 'submitQuiz'])->middleware('auth'); // param : answers, quizId

