<?php
use Illuminate\Support\Facades\Route;

/*   DB::listen(function($query) {
echo "<pre>{$query->sql} - {$query->time}</pre>";
});
  */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/', function (Request $request) {
    return view('welcome');
});

 
//FRASE DEL DÍA
Route::get('frase'          , 'FrasesController@sentenceToday');

//CONTACTOS
Route::post('contactos', 'TercerosContactatosController@saveContacto');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
