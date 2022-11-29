<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\V1\SkillController;
use App\Http\Middleware\Authenticate;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'v1'], function () {

    Route::controller(SkillController::class)->group(function () {

        Route::get('/skills', 'index')->name('all.skill');
        Route::get('/skills/{skill}', 'show')->name('single.skill');
        Route::post('/skills', 'store')->name('new.skill');
        Route::post('/skills/{skill}', 'update')->name('update.skill');
        Route::delete('/skills/{skill}', 'destroy')->name('delete.skill');
    });

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login.user');
    Route::post('/register', [AuthController::class, 'register'])->name('register.user');

    Route::middleware('auth:api')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('/users', [AuthController::class, 'show'])->name('single.user');
    });
});
