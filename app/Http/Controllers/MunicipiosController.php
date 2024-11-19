<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Municipio as Municipios;

class MunicipiosController extends Controller
{
    public function MunicipiosPorDepartamento (request $FormData ) {
        return Municipios::where('id_dpto',$FormData->id_dpto)
        ->where('inactivo','=', '0')
        ->orderBy('nom_mcipio')->get();
    }
}
