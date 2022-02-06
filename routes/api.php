<?php

use App\Http\Controllers\Api\V1\Countries\CountryController;
use App\Http\Controllers\Api\V1\Users\UserController;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

/*
|--------------------------------------------------------------------------
| Api Country routes
|--------------------------------------------------------------------------
*/
Route::prefix('{api_version}/countries')->as('api.countries.')->where(['api_version' => get_api_versions()])->group(static function () {
    Route::get('/', [CountryController::class, 'index'])->name('index');
    Route::get('/{id}', [CountryController::class, 'show'])->where(['id' => '[a-zA-Z0-9-]+'])->name('show');
});


/*
|--------------------------------------------------------------------------
| Api Users routes
|--------------------------------------------------------------------------
*/
Route::prefix('{api_version}/users')->as('api.users.')->where(['api_version' => get_api_versions()])->group(static function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/country', [UserController::class, 'getAustrianCountryIsoAndActiveUsers'])->name('country');
    Route::put('/{id}/details', [UserController::class, 'updateDetails'])->where(['id' => '[a-zA-Z0-9-]+'])->name('update_details');
    Route::delete('/{id}', [UserController::class, 'destroy'])->where(['id' => '[a-zA-Z0-9-]+'])->name('destroy');
    Route::get('/{id}', [UserController::class, 'show'])->where(['id' => '[a-zA-Z0-9-]+'])->name('show');
});
