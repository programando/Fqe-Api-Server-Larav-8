<?php
use Illuminate\Support\Facades\Route;

/*   DB::listen(function($query) {
echo "<pre>{$query->sql} - {$query->time}</pre>";
});
  */




Route::get('/', function (Request $request) {
    return view('welcome');
});

 
//FRASE DEL DÍA
Route::get('frase'          , 'FrasesController@sentenceToday');

//CONTACTOS
Route::post('contactos', 'TercerosContactatosController@saveContacto');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


 Route::post('/login'            , 'TercerosUserController@login')->name('login');
Route::post('/logout'           , 'TercerosUserController@logout')->name('logout'); 
Route::post('/reset/password'   , 'TercerosUserController@resetPassword')->name('reset-password'); 
Route::post('/update/password'  , 'TercerosUserController@updatePassword')->name('update-password'); 


// Route::get('/mail', function () {
//   $details = [
//       'subject' => 'Correo de prueba',
//       'body' => 'Este es un correo de prueba enviado desde Laravel en local.'
//   ];

//   Mail::raw($details['body'], function ($message) use ($details) {
//       $message->to('jhonjamesmg@hotmail.com')
//               ->subject($details['subject']);
//   });

//   return 'Correo enviado.';
// });