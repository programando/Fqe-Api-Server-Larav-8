<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tercero as Clientes;
use App\Models\TercerosUser as Usuario;

class TercerosClientesController extends Controller
{
    var $EsNuevoRegistro = false;

    public function NuevoRegistro ( request $FormData ) {
        
        $Cliente                = $this->BuscarNitEmail ($FormData->nro_dcmnto, $FormData->email );
        $Cliente->id_tp_dcmnto  = $FormData->id_tp_dcmnto ;
        $Cliente->id_tp_persona = $FormData->id_tp_persona;
        $Cliente->id_mcipio     = $FormData->id_mcipio ;
        $Cliente->nro_dcmnto    = $FormData->nro_dcmnto ;
        $Cliente->p_nombre      = $FormData->p_nombre ;
        $Cliente->p_apellido    = $FormData->p_apellido ;
        $Cliente->nro_telefono  = $FormData->nro_telefono ;
        $Cliente->direccion     = $FormData->direccion ;
        $Cliente->email         = $FormData->email ;
        $Cliente->complemento   = $FormData->complemento ;
        $Cliente->es_cliente    = true ;
        
        $Cliente->save();
    
        if ( $this->EsNuevoRegistro === true ){
            $Usuario            = new Usuario;
            $Usuario->email     = $FormData->email ;
            $Usuario->id_terc  = $Cliente->idtercero ;
            $Usuario->password  = $FormData->password ;
            $Usuario->save();
        }
        return $Cliente;

    }


    private function BuscarNitEmail ( $Nit, $Email ) {
        $RegistroCliente = Clientes::where('nro_dcmnto','=',$Nit  )->orWhere('email','=',$Email)->first();
        if (  $RegistroCliente ) {
            $this->EsNuevoRegistro = false ;
            return $RegistroCliente;
        }  
        if (  !$RegistroCliente ) {
            $this->EsNuevoRegistro = true ;
            return new Clientes;
        }   
    }


    public function BuscarEmail ( request $FormData ) {
        $RegistroCliente = Clientes::Where('email','=',$FormData->email)->first();
        if (  $RegistroCliente ) {
            return Clientes::with('TiposDocumento','Municipios','TiposPersonas', 'Municipios.Departamentos')->Where('email','=',$FormData->email)->first();
        }  
        return (object)[];
    }

    public function BuscarIdentificacion ( request $FormData ) {
        $RegistroCliente = Clientes::Where('nro_dcmnto','=',$FormData->nro_dcmnto)->first();
        if (  $RegistroCliente ) {
            return Clientes::with('TiposDocumento','Municipios','TiposPersonas')->Where('nro_dcmnto','=',$FormData->nro_dcmnto)->first();
        }  
        return (object)[];  
    }

}
