<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\EventCategoryController;
use App\Http\Controllers\Api\MeetController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


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

Route::prefix('event')->group(function(){
    Route::get('/', [EventController::class, 'index']);
    Route::get('/{id}', [EventController::class, 'show']);
    Route::get('/by-category/{id}', [EventController::class, 'getEventByCategory']);
});


Route::prefix('event-category')->group(function(){
    Route::get('/', [EventCategoryController::class, 'index']);
});

Route::prefix('meet')->group(function(){
    Route::get('/', [MeetController::class, 'index']);
    Route::get('/{id}', [MeetController::class, 'show']);

});

Route::group(['middleware'=>['api','jwt.verify']], function(){
    Route::prefix('event')->group(function(){
        Route::post('/create', [EventController::class, 'store']);
    });

    Route::prefix('meet')->group(function(){
        Route::post('/create', [MeetController::class, 'store']);
    });

});