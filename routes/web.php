<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Generate a login URL
Route::get('/facebook/login', 'FacebookController@login')->name('fbLogin');

// Endpoint that is redirected to after an authentication attempt
Route::get('/facebook/callback', 'FacebookController@callback')->name('fbCallback');

Route::get('/logout', 'FacebookController@logout')->name('logout');


Route::get('/', 'MainController@index')->name('home');
Route::group(['middleware' => 'web'], function() {
    // facebook area
    Route::post('/facebook/get-members', 'FacebookController@groupMembers')->name('fbGetMembers');

    // administrative
    Route::get('/members', 'MemberController@index')->name('members');
    Route::get('/admins', 'MemberController@admin')->name('admins');

    // candidates area
    Route::prefix('candidates')->group(function () {
        Route::get('/', 'CandidateController@index')->name('candidates');
        Route::get('/add', 'CandidateController@add')->name('candidateAdd');
        Route::post('/add', 'CandidateController@store')->name('candidateStore');
        Route::post('/delete/{id}', 'CandidateController@delete')->name('candidateDelete');
    });

    Route::post('/voting', 'MainController@voting')->name('voting');

    Route::prefix('config')->group(function () {
        Route::get('/header', 'ConfigController@header')->name('configHeader');
        Route::post('/header', 'ConfigController@headerStore')->name('configHeaderStore');
    });
});

Route::get('storage/{filename}', 'CandidateController@picture');