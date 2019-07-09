<?php
/*
|--------------------------------------------------------------------------
| Newpixel\GeographyCRUD Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Newpixel\GeographyCRUD package.
|
*/
Route::group([
    'namespace' => 'Newpixel\GeographyCRUD\app\Http\Controllers\Admin',
        'prefix' => config('backpack.base.route_prefix', 'admin'),
        'middleware' => ['web', backpack_middleware()],
    ], function () {
        CRUD::resource('continent', 'ContinentCrudController');
        CRUD::resource('country', 'CountryCrudController');
        CRUD::resource('city', 'CityCrudController');
    });
