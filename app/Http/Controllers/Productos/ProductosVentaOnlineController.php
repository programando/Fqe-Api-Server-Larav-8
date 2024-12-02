<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductosVentaOnline as Productos;

class ProductosVentaOnlineController extends Controller
{
    
    public function Productos () {
        return Productos::Productos();
    }

    public function ProductoPresentaciones (Request $FormData) {
        return Productos::ProductoPresentaciones($FormData->idproducto_ppal );
    }
    
    public function ProductoPresentacionesTodos ( ) {
        return Productos::ProductoPresentacionesTodos( );
    }

    
}
