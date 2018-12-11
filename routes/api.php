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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post('users/iniciar', 'UsuarioControllers@iniciar');
Route::post('users/registrar', 'UsuarioControllers@registrar');

Route::get('users/ubicaciones',function (){
    return response()->json(\Illuminate\Support\Facades\DB::table("ubicaciones")->get());
});

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('users/estado', 'UsuarioControllers@estado');
    Route::get('users/persona','PersonaControllers@ver');
    Route::post('users/guardarPersona','PersonaControllers@registrar');
    Route::post('users/actualizarPersona','PersonaControllers@actualizar');
    Route::get('users/verGps',"UbicacionControllers@ver");
});
