<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PedidosVentaOnline;
use App\Models\PedidosDtVentaOnline;
use App\Models\ProductosVentaOnline as Productos;
use App\Models\ProductosVentaOnlineCombo as ProductosVentaOnlineCombos;


use Fechas;

class PedidosVentaOnlineController extends Controller
{
   
    public function PedidoCrearNuevo (Request $FormData) {
       
        $Pedido                 = new PedidosVentaOnline();
        $Pedido->idtercero      = $FormData->idtercero;
        $Pedido->fcha_pddo      = Fechas::getHoy();
        $Pedido->fecha_vence    = Fechas::AddHoras(8);
        $Pedido->vr_productos   = $FormData->vr_productos;
        $Pedido->vr_flete       = $FormData->vr_flete;
        $Pedido->vr_obsequios   = $FormData->vr_obsequios;
        $Pedido->vr_total       = $FormData->vr_total;
        $Pedido->payu_reference = $FormData->payu_reference;
        $Pedido->payu_signature = $FormData->payu_signature;

        $Pedido->save();
        $this->PedidoDtCrearNuevo( $Pedido, $FormData );
        return $Pedido;
    }

    private function PedidoDtCrearNuevo ( $Pedido, $FormData ) {
        $DetallePedido   = [] ; $peso_kg = 0; $vr_productos = 0; $vr_flete = 0; $vr_total = 0;
        $CombosPedido = $FormData['ProductosPedido']; // ES EL COMBO QUE VIENE DEL CLIENTE
        // Recorremos los productos del pedido ( combos )
        
        foreach ($CombosPedido as $Combo) {
            // por cada combo, recorremos los productos que lo componen
            
            $ProductosComponentesCombo = ProductosVentaOnlineCombos::ProductosComponentes( $Combo['idkeyproducto'] );
            
            foreach ($ProductosComponentesCombo as $ProductoCombo ){
                    $peso_kg      += $ProductoCombo['productos']['peso_kg']      * $ProductoCombo['cantidad'];
                    $vr_productos += $ProductoCombo['productos']['precio_venta'] * $ProductoCombo['cantidad'];
                    $vr_unitario   = $ProductoCombo['precio_venta'];
                    $vr_total      = $ProductoCombo['precio_venta'] * $ProductoCombo['cantidad'];
                    $es_obseqio    = $this->getBit($ProductoCombo['es_obsequio']);
 
                    if (  $es_obseqio === true ) {
                        $vr_unitario = 0;
                        $vr_total    = 0;
                    }

                    $DetallePedido[] = [
                        'idpddo'      => $Pedido->idpddo,
                        'idproducto'  => $ProductoCombo['idproducto'],
                        'cantidad'    => $ProductoCombo['cantidad'],
                        'vr_unitario' => $vr_unitario,
                        'vr_total'    => $vr_total,
                        'es_obsequio' => $es_obseqio
                    ];
            }
        }

        if (count($DetallePedido) > 0)  {

            if ( $Pedido->vr_flete > 0) {           // Si tiene flete, lo agregamos al pedido
                $DetallePedido[] = [
                    'idpddo'      => $Pedido->idpddo,
                    'idproducto'  => 5128, // ID DEL PRODUCTO FLETE
                    'cantidad'    => 1,
                    'vr_unitario' => $Pedido->vr_flete,
                    'vr_total'    => $Pedido->vr_flete,
                    'es_obsequio' => 0
                ];         
            }
            
            PedidosDtVentaOnline::insert($DetallePedido);
            $this->PedidoActualizarDatos( $Pedido, $peso_kg   );
        }
    }

    private function PedidoActualizarDatos ( $Pedido, $peso_kg  ) {
        $Pedido->peso_kg              = $peso_kg ; 
        $Pedido->save();
    }

    public function PedidoConfirmacionPagoRecibido (Request $FormData) {
        $Pedido                = PedidosVentaOnline::with('PedidoDt.Productos')->where('idpddo',$FormData->idpddo)->first();
        $Pedido->pago_recibido = true;                                                           /*  OTROS DATOS DEL PAGO RECIEN RECIBIDO */
        $Pedido->save();
        return $Pedido;
         
    }




}
