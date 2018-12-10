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

/**Route::get('/', function () {
    return view('welcome');
});
*/

/*
if(env('APP_ENV') === 'production' || env('APP_ENV') === 'dev'){
    $this->app['request']->server->set('HTTPS', true);
    \URL::forceScheme('https');
}*/

Route::get('/','MainControllers@index');
Route::get('/panel','MainControllers@panel');
Route::get('/map','MainControllers@map');
