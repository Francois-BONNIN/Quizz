<?php

use App\Http\Controllers\AuthController;
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

Route::get('/quiz');
Route::get('/quiz/{id}');
Route::post('/quiz'); // param quiz
Route::put('/quiz/{quizId}'); // param quiz
Route::delete('/quiz/{quiz.id}');
Route::post('/quiz/{quiz.id}/publish');
Route::post('/quiz/{quiz.id}/unpublish');
Route::get('/quiz/{quizId}/questions');

Route::get('/question/{questionId}/choices');

Route::post('/score'); // param answers, quizId
Route::get('/score');

Route::get('/user/{userId}');
