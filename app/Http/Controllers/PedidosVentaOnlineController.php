<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PedidosVentaOnline;
use App\Models\PedidosDtVentaOnline;
use App\Events\PedidoConfirmacionPagoRecibidoEvent;
use Fechas;

class PedidosVentaOnlineController extends Controller
{
   
    public function PedidoCrearNuevo (Request $FormData) {
        $Pedido                       = new PedidosVentaOnline();
        $Pedido->idtercero            = $FormData->idtercero;
        $Pedido->fcha_pddo            = Fechas::FechaActual();
        $Pedido->fecha_vence          = Fechas::AddHoras(8);
        $Pedido->peso_kg              = $FormData->peso_kg; 
        $Pedido->vr_pddo              = $FormData->vr_pddo;
        $Pedido->vr_flete             = $FormData->vr_flete;
        $Pedido->vr_total             = $FormData->vr_total;
        $Pedido->save();
        $this->PedidoDtCrearNuevo( $Pedido, $FormData );
        return $Pedido;
    }

    private function PedidoDtCrearNuevo ( $Pedido, $FormData ) {
        $DetallePedido = [];
        $ProductosPedido             = $FormData['ProductosPedido'];
        foreach ($ProductosPedido as $Producto) {
            $DetallePedido[] = [
                'idpddo'     => $Pedido->idpddo,
                'idproducto' => $Producto['idproducto'],
                'cantidad'   => $Producto['cantidad'],
                'vr_unitario'=> $Producto['vr_unitario'],
                'vr_total'   => $Producto['vr_total']
            ];
        }
        if (count($DetallePedido) > 0)  PedidosDtVentaOnline::insert($DetallePedido);
    }

    public function PedidoConfirmacionPagoRecibido (Request $FormData) {
        $Pedido                = PedidosVentaOnline::with('PedidoDt.Productos')->where('idpedido',$FormData->idpddo)->get();
        $Pedido->pago_recibido = true;                                                           /*  OTROS DATOS DEL PAGO RECIEN RECIBIDO */
        $Pedido->save();
        return $Pedido;
        PedidoConfirmacionPagoRecibidoEvent::dispatch($Pedido );
    }


   


}
