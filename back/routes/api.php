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

Route::middleware( 'auth:api' )->group( function () {
    Route::get( 'father_details', 'Api\FatherController@getDetails' )->name( 'api.get_father_details' );

    Route::get( 'class', 'Api\ClassController@getClasses' )->name( 'api.get_classes' );

    Route::get( 'section', 'Api\SectionController@getSections' )->name( 'api.get_sections' );

    Route::get( 'get-fee', 'Api\StudentFeeApiController@getFee' )->name( 'api.get_fee' );
} );
