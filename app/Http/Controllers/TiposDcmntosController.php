<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TiposDcmnto;

class TiposDcmntosController extends Controller
{
    public function ListarTodos () {
        return TiposDcmnto::where('inactivo','=','0')->orderBy('nom_tp_dcmnto')->get();
    }
}
