<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AttendantController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\RecepcionistController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login',[AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});


Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'
], function ($router) {

    Route::apiResource('attendant', AttendantController::class)
        ->middleware('can:attendants');

    Route::apiResource('doctor', DoctorController::class)
        ->middleware('can:doctors');

    Route::apiResource('recepcionist', RecepcionistController::class)
        ->middleware('can:recepcionists');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'
], function ($router) {

    Route::post('appointment',
    [AppointmentController::class, 'store'])
    ->middleware('can:schedule_appointments');

    Route::get('appointment',
    [AppointmentController::class, 'list'])
    ->middleware('can:show_appointments');

    Route::group([
        'middleware' => 'api',
        'prefix' => '{appointment:id}'
    ], function ($router) {

        Route::get('appointment',
        [AppointmentController::class, 'show'])
        ->middleware('can:show_appointments');

        Route::put('appointment',
        [AppointmentController::class, 'update']
        )->middleware('can:update_appointments');

        Route::delete('appointment',
        [AppointmentController::class, 'destroy']
        )->middleware('can:delete_appointments');

        Route::put('appointment/attach/{user:id}',
            [AppointmentController::class, 'attach']
        )->middleware('can:attach_appointments');
    });

    Route::group([
        'middleware' => 'api',
        'prefix' => 'my'
    ], function ($router) {
        Route::get('/appointments', [AppointmentController::class, 'listByUser'])
            ->middleware('can:view_my_appointments');

        Route::put('/appointments/{appointment:id}',
            [AppointmentController::class, 'updateByUser']
            )->middleware('can:update_my_appointments');
    });
});

