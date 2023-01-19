<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Candidate\CandidateController;
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

Route::post(config('settings.version_api') . '/auth/signin', [AuthController::class, 'auth'])->name('signin');
Route::patch(config('settings.version_api') . '/auth/signout', [AuthController::class, 'signout'])->name('signout');

Route::middleware('verify')->group(function () {
    Route::prefix(config('settings.version_api'))->group(function() {
        Route::get('/candidate/view', [CandidateController::class, 'index'])->name('candidate.view');
        Route::post('/candidate/add', [CandidateController::class, 'store'])->name('candidate.add');
        Route::get('/candidate/read/{id}', [CandidateController::class, 'show'])->name('candidate.read');
        Route::post('/candidate/edit/{id}', [CandidateController::class, 'update'])->name('candidate.edit');
        Route::delete('/candidate/delete/{id}', [CandidateController::class, 'delete'])->name('candidate.delete');
    });
});
