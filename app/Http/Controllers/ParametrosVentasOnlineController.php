<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ParametrosVentasOnline as Parametros;

class ParametrosVentasOnlineController extends Controller
{
    public function ParametrosConsultar ( ) {
        return Parametros::Listar();
    }
}
