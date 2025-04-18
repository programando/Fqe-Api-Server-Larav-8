<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PedidosVentaOnline;
use App\Models\PedidosDtVentaOnline;
use App\Events\PedidoConfirmacionPagoRecibidoEvent;
use App\Models\ProductosVentaOnline as Productos;


use Fechas;

class PedidosVentaOnlineController extends Controller
{
   
    public function PedidoCrearNuevo (Request $FormData) {
        
        $Pedido                 = new PedidosVentaOnline();
        $Pedido->idtercero      = $FormData->idtercero;
        $Pedido->fcha_pddo      = Fechas::getHoy();
        $Pedido->fecha_vence    = Fechas::AddHoras(8);
        $Pedido->vr_flete       = $FormData->vr_flete;
        $Pedido->payu_reference = $FormData->payu_reference;
        $Pedido->payu_signature = $FormData->payu_signature;
        $Pedido->save();
        $this->PedidoDtCrearNuevo( $Pedido, $FormData );
        return $Pedido;
    }

    private function PedidoDtCrearNuevo ( $Pedido, $FormData ) {
        $DetallePedido   = [] ; $peso_kg = 0; $vr_pddo = 0; $vr_flete = 0; $vr_total = 0;
        $ProductosPedido = $FormData['ProductosPedido'];
        
        foreach ($ProductosPedido as $Producto) {
            $ProductoBase  = Productos::where('idproducto_ppal', $Producto['url_key'])->first();
            $peso_kg      += $ProductoBase['peso_kg'] * $Producto['cantidad'];
            $vr_pddo      += $Producto['precio_venta'] * $Producto['cantidad'];
            $DetallePedido[] = [
                'idpddo'     => $Pedido->idpddo,
                'idproducto' => $Producto['idproducto'],
                'cantidad'   => $Producto['cantidad'],
                'vr_unitario'=> $Producto['precio_venta'],
                'vr_total'   => $Producto['precio_venta'] * $Producto['cantidad']
            ];
        }
        if (count($DetallePedido) > 0)  {
            PedidosDtVentaOnline::insert($DetallePedido);
            $this->PedidoActualizarDatos( $Pedido, $peso_kg ,$vr_pddo  );
        }
    }

    private function PedidoActualizarDatos ( $Pedido, $peso_kg, $vr_pddo  ) {
        $Pedido->peso_kg              = $peso_kg ; 
        $Pedido->vr_pddo              = $vr_pddo;
        $Pedido->vr_total             = $Pedido->vr_flete + $vr_pddo;
        $Pedido->save();
    }

    public function PedidoConfirmacionPagoRecibido (Request $FormData) {
        $Pedido                = PedidosVentaOnline::with('PedidoDt.Productos')->where('idpddo',$FormData->idpddo)->first();
        $Pedido->pago_recibido = true;                                                           /*  OTROS DATOS DEL PAGO RECIEN RECIBIDO */
        $Pedido->save();
        return $Pedido;
        PedidoConfirmacionPagoRecibidoEvent::dispatch($Pedido );
    }




}
