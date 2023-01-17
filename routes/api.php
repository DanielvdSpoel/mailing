<?php

use App\Http\Controllers\Api\AuthenticationController;
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

Route::post('/auth/login', [AuthenticationController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/inbox')->group(function () {
        Route::get('/', [InboxController::class, 'index']);
        Route::get('/paginated', [InboxController::class, 'store']);
        Route::get('/{id}', [InboxController::class, 'show']);
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

