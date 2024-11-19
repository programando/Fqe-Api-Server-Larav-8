<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TiposPersona;
class TiposPersonasController extends Controller
{
    public function ListarTodas () {
        return TiposPersona::orderBy('nom_tp_persona')->where('inactivo','=','0')->get();
    }
}
