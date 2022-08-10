<?php
use Illuminate\Support\Facades\Route;

/*    DB::listen(function($query) {
echo "<pre>{$query->sql} - {$query->time}</pre>";
});
  */

use Illuminate\Http\Request;


// DOCUMENTO SOPORTE
Route::group(['prefix'=>'docsoporte', 'namespace'=>'Api'], function() {
    $localController = 'DcmntosSprteController@';
    Route:: get('/reporte/dian'          , $localController.'documentosSoporte');
});

 
Route::post('/login'            , 'TercerosUserController@login')->name('login');
Route::post('/logout'           , 'TercerosUserController@logout')->name('logout'); 
Route::post('/reset/password'   , 'TercerosUserController@resetPassword')->name('reset-password'); 
Route::post('/update/password'  , 'TercerosUserController@updatePassword')->name('update-password'); 

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//LINEAS
Route::group(['prefix'=>'lineas', 'namespace'=>'Api' ], function() {
    Route::get('/activas'                 , 'MstroLineasController@activas');
});


//PRODUCTOS
Route::group(['prefix'=>'productos', 'namespace'=>'Api' ], function() {
        //Route::get('/precios'                 , 'PrdctoController@listaPrecios')->name('lista-precios');
        Route::get('/por-clase'                 , 'PrdctoController@getProductosPorClase');
        Route::get('/por-linea'                 , 'PrdctoController@getProductosPorLinea');
 });

//CLASES DE PRODUCTO
Route::group(['prefix'=>'clases/productos', 'namespace'=>'Api'], function() {
        Route::get('/por-linea'                 , 'MstroClasesPrdctoController@getClasesPorLinea');
 });


//CARTERA CLIENTES CxC
Route::group(['prefix'=>'cartera', 'namespace'=>'Api'], function(){
    $localController = 'CarteraFacturasController@';
    Route::get('/clientes'                 , $localController.'clientesCxcPorVendedor');
    Route::get('/cliente/facturas'         , $localController.'facturasPorNit');
    Route::get('/vendedor/total'           , $localController.'totalPorVendedor');
 
 });


//PINES PARA PAGO ELECTRONICO
Route::group([ 'namespace'=>'Api'], function(){
    $localController = 'PinesPgoElectronicoController@';
    Route::get('/pin'               , $localController.'buscarPin');
    Route::get('/pedido'            , $localController.'buscarPedido');
    Route::get('/factura'            , $localController.'buscarFactura');
 });

Route::group(['prefix'=>'ventas', 'namespace'=>'Api'], function(){
    $localController = 'BtcraVtasController@';
    Route::get('/vendedor'                 , $localController.'ventasVendedorUltimosDosAnios');
 });


Route::group(['prefix'=>'terceros', 'namespace'=>'Api'], function(){
    $localController = 'TercerosController@';
    Route::get('/clientes/busqueda'                             , $localController.'clientesBuscarNomSucNitNomCcial');
    Route::get('/clientes/productos/comprados'                  , $localController.'clientesProductosComprados');
 });


// NOMINA ELECTRONICA
    Route::group(['prefix'=>'nomina', 'namespace'=>'Api'], function() {
        $localController = 'NominaElctrncaController@';
        Route:: get('/reporte/dian'          , $localController.'dianReporting');
        Route:: post('/nota/ajuste'           , $localController.'notaAjusteNomina');
        Route:: post('zipkey/{id}'           , $localController.'zipKey');
    });
 


// INVOICES
    Route::group(['prefix'=>'invoices', 'namespace'=>'Api'], function() {
        $localController = 'FctrasElctrncasInvoicesController@';
        Route:: get('/'                          , $localController.'invoices')->name('invoices');
        Route:: get('pdf/{id}'                   , $localController.'invoiceSendToCustomer');
        Route:: get('/download/{filetype}/{id}'  , $localController.'invoiceFileDownload');
        Route:: get('accepted/{id}'              , $localController.'invoiceAccepted');
        Route:: get('rejected/{id}'              , $localController.'invoiceRejected');
        Route:: post('logs'                      , $localController.'sentInvoicesLogs');
    });
 

Route::resource('facturas-electronicas', 'Api\FctrasElctrncaController', ['only'=> ['index', 'show', '']] );


Route::group(['prefix'=>'productos', 'namespace'=>'Api'], function() {
        Route::get('/precios'           , 'PrdctoController@listaPrecios')->name('precios');
 });

// NOTES
    Route::group(['prefix'=>'notes', 'namespace'=>'Api'], function() {
        $localController = 'FctrasElctrncasNotesCrController@';
        Route::get('pdf/{id}'             , $localController.'noteSendToCustomer');
        Route::get('{tpNote}'             , $localController.'notes');
        Route::post('logs'                       , $localController.'sentNotesLogs');
    });
