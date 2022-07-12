<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\TransfersController;
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

Route::group(['prefix' => 'accounts'], function () {
    Route::post('/', [AccountsController::class, 'store']);
    Route::get('/{id}', [AccountsController::class, 'show'])->name('account_show');
    Route::get('/{id}/transfers', [AccountsController::class, 'transfers'])->name('account_transfers');
});


Route::group(['prefix' => 'transfers'], function () {
    Route::post('/', [TransfersController::class, 'store']);
});
