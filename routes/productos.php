<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Productos\ProductosVentaOnlineController;
 

Route::controller( ProductosVentaOnlineController::class )
        ->prefix('ventas/online/')
        ->group ( function () {
                Route::get('productos/shop'                                   , 'ShopProductos') ;
                Route::post('producto/presentaciones'                         , 'ProductoPresentaciones') ;
                Route::get('producto/presentaciones/todas'                    , 'ProductoPresentacionesTodos') ;
                Route::post('producto/buscar/id/producto'                     , 'ProductoBuscarId') ;
                Route::post('producto/actualizar'                             , 'ProductoActualizar') ;
});


Route::controller( ProductosVentaOnlineController::class )
        ->prefix('ventas/online/productos/combos/')
        ->group ( function () {
                Route::get('todos'                                      , 'ProductoCombosTodos') ;
                Route::post('crear/actualizar'                          , 'ProductoComboCrearActualizar') ;
                Route::post('buscar/id'                                 , 'ProductoComboPorIdKeyProducto') ;
});


/*
      
*/

