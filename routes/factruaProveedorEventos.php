<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

 
 // PREFIX ->  proveedores

$localController = 'FctrasElctrncasEventsController@';

Route:: get('/facturas/recibidas'          , $localController.'getFacturasProveedores');

Route:: post('set/030/acuse'                       , $localController.'acuseRecibo')                   ;
Route:: post('set/031/rechazo'                     , $localController.'rechazoReclamo')                ;
Route:: post('set/032/recibo-bien-servicio'        , $localController.'reciboBienServicio')            ;
Route:: post('set/033/aceptacion-expresa'          , $localController.'aceptacionExpresa')             ;
Route:: post('set/all'                             , $localController.'aceptacionExpresa')             ;
Route:: post('recepcionadas'                       , $localController.'documentosRecepcionados')       ;
Route:: post('consulta'                            , $localController.'allEvents')                     ;





