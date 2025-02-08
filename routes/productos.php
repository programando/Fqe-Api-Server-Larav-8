<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Productos\ProductosVentaOnlineController;
 

Route::controller( ProductosVentaOnlineController::class )
        ->prefix('ventas/online/productos/')
        ->group ( function () {
                Route::get('shop'                                    , 'ShopProductos') ;
                Route::post('presentaciones'                        , 'ProductoPresentaciones') ;
                Route::get('presentaciones/todas'                   , 'ProductoPresentacionesTodos') ;
                Route::post('buscar/id/producto'                    , 'ProductoBuscarId') ;
                Route::post('actualizar'                             , 'ProductoActualizar') ;
                Route::post('actualizar/campo'                       , 'ProductoActualizarCampo') ;
});


Route::controller( ProductosVentaOnlineController::class )
        ->prefix('ventas/online/productos/combos/')
        ->group ( function () {
                Route::get('todos'                                      , 'ProductoCombosTodos') ;
                Route::post('crear/actualizar'                          , 'ProductoComboCrearActualizar') ;
                Route::post('buscar/id'                                 , 'ProductoComboPorIdKeyProducto') ;
});


 
