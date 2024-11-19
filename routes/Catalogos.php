
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TiposDcmntosController;
use App\Http\Controllers\TiposPersonasController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\MunicipiosController;
 
Route::controller( TiposDcmntosController::class )->group ( function () {  Route::get('catalogos/tipos/documentos' , 'ListarTodos') ; });
Route::controller( TiposPersonasController::class )->group ( function () {  Route::get('catalogos/tipos/personas' , 'ListarTodas') ; });
Route::controller( TiposPersonasController::class )->group ( function () {  Route::get('catalogos/departamentos' , 'ListarTodos') ; });
Route::controller( TiposPersonasController::class )->group ( function () {  Route::get('catalogos/municipios/por/departamento' , 'MunicipiosPorDepartamento') ; });

?>

 
 


