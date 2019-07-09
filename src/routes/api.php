<?php

use Illuminate\Http\Request;

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

// Backpack
Route::prefix('api')->group(function () {
    Route::group(['middleware' => ['api']], function () {
        Route::get('country-filter-options', 'Newpixel\GeographyCRUD\App\Http\Controllers\Api\CountryController@backpackCountryFilterOptions');
        Route::get('cities-filter-options', 'Newpixel\GeographyCRUD\App\Http\Controllers\Api\CityController@citiesFilterOptions');
        Route::post('city-import-units', 'Newpixel\GeographyCRUD\App\Http\Controllers\Api\CityController@importUnitsFromBibi')->name('city-import-units');
    });
});
