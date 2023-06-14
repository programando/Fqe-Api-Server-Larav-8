<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Producto as Productos;

class ProductoController extends Controller
{
    public function ListaTodosProductos(){
        return Productos::Where('inactivo','0')->orderBy('id_clse_prdcto')->get();
    }

    public function ProductosPorClaseProducto( request $FormData ){
         
        return Productos::Where('inactivo','0')
                          ->where('id_clse_prdcto','=', $FormData->id_clse_prdcto)
                          ->orderBy('id_clse_prdcto')->get();
    }


}
