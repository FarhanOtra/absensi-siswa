<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AttendanceController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/home', [AttendanceController::class, 'home']);
    Route::get('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/getAttendance/{id}', [AttendanceController::class, 'getAttendance']);
    Route::get('/getHistory', [AttendanceController::class, 'getHistory']);
    Route::get('/getRequest', [AttendanceController::class, 'getRequest']);
    Route::post('/postLeave', [AttendanceController::class, 'postLeave']);
    Route::post('/auth/changePassword', [AuthController::class, 'changePassword']);
});

Route::post('/auth/login', [AuthController::class, 'login']);

