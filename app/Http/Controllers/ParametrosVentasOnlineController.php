<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ParametrosVentasOnline as Parametros;

class ParametrosVentasOnlineController extends Controller
{
    public function ParametrosConsultar ( ) {
        return Parametros::Listar();
    }


    public function ParametrosActualizar (Request $FormData) {
        $Param = Parametros::where('idregistro', $FormData->idregistro)->first();
         
        $Param->prcntje_utldad = $FormData->prcntje_utldad ;
        $Param->prcntje_iva    = $FormData->prcntje_iva ;
        $Param->prcntje_cmsion = $FormData->prcntje_cmsion ;
        $Param->prcntje_seguro = $FormData->prcntje_seguro ;
        $Param->prcntje_manejo = $FormData->prcntje_manejo ;
        $Param->payu_prcntje   = $FormData->payu_prcntje ;
        $Param->payu_vr_fijo   = $FormData->payu_vr_fijo ;
        $Param->kg_max_envio   = $FormData->kg_max_envio ;
        $Param->vr_min_envio   = $FormData->vr_min_envio ;
        $Param->vr_kg_ini_urb  = $FormData->vr_kg_ini_urb ;
        $Param->vr_kg_ini_nac  = $FormData->vr_kg_ini_nac ;
        $Param->vr_kg_adc_urb  = $FormData->vr_kg_adc_urb ;
        $Param->vr_kg_adc_nac  = $FormData->vr_kg_adc_nac ;
        $Param->save();
        return $Param;
    }
}
