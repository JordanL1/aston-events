<?php

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

Route::get('/', 'DisplayController@showAll')->name('all');
Route::get('/event/{id}', 'DisplayController@showById')->name('showById');
Route::get('/event', 'DisplayController@filter')->name('show');
Route::delete('/event/{id}', 'EventController@deleteEvent')->name('deleteEvent');

Route::get('/create_event', 'EventController@createForm')->name('eventForm');
Route::post('/create_event', 'EventController@createEvent')->name('createEvent');

Route::get('/update/event/{id}', 'EventController@updateForm')->name('updateForm');
Route::post('/update/event/{id}', 'EventController@updateEvent')->name('updateEvent');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
