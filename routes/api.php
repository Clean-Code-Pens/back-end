<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MeetController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\MeetRequestController;
use App\Http\Controllers\Api\EventCategoryController;

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
    Route::post('/search', [EventController::class, 'searchEvent']);
});


Route::prefix('event-category')->group(function(){
    Route::get('/', [EventCategoryController::class, 'index']);
});

Route::prefix('meet')->group(function(){
    Route::get('/', [MeetController::class, 'index']);
    Route::get('/{id}', [MeetController::class, 'show']);
    Route::post('/search', [MeetController::class, 'searchMeet']);


});

Route::prefix('meetbyevent')->group(function(){
    Route::post('/event', [MeetController::class, 'event']);
    Route::get('/{id}', [MeetController::class, 'byevent']);
});

Route::group(['middleware'=>['api','jwt.verify']], function(){
    Route::prefix('event')->group(function(){
        Route::post('/create', [EventController::class, 'store']);
        Route::post('/create-base', [EventController::class, 'storebase']);
        Route::post('/my', [EventController::class, 'myEvent']);

    });

    Route::prefix('meet')->group(function(){
        Route::post('/create', [MeetController::class, 'store']);
        Route::post('/my', [MeetController::class, 'myMeet']);
        Route::post('/my-join', [MeetController::class, 'myJoinMeet']);
        Route::post('/my-detail', [MeetController::class, 'myDetailMeet']);


    });

    Route::prefix('meet-request')->group(function(){
        Route::post('/create', [MeetRequestController::class, 'store']);
        Route::post('/accept', [MeetRequestController::class, 'acceptMeet']);
        Route::post('/reject', [MeetRequestController::class, 'rejectMeet']);

    });

});