<?php

use App\Http\Controllers\RemessaController;
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

Route::post('upload', [RemessaController::class, 'upload']);
//Route::post('job-save-database', [RemessaController::class, 'jobSaveDatabase']);
//Route::post('job-make-boleto', [RemessaController::class, 'jobMakeBoleto']);
//Route::post('job-send-email', [RemessaController::class, 'jobSendEmail']);

Route::get('/health', function (Request $request) {
    return response()->json(['ok' => true]);
});

Route::post('/mock/make/boleto', function(Request $request) {
    sleep(1);
    return response()->json(['ok' => true]);
});
