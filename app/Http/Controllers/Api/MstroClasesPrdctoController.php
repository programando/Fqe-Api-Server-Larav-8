<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MstroClasesPrdcto as ProductosClases ;

class MstroClasesPrdctoController extends Controller
{
    
    public function getClasesProductos (  ) {
        return ProductosClases::Where('inactivo','0')
                ->Where('id_clse_prdcto','>','0')
                ->orderBy('nom_clse_prdcto')->get() ;
    }


}
