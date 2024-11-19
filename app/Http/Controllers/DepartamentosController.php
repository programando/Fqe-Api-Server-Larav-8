<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Departamento as Departamentos;

class DepartamentosController extends Controller
{
    
    public function ListarTodos () {
        return Departamentos::where('inactivo','=','0')->orderBy('nom_dpto')->get();
    }
}
