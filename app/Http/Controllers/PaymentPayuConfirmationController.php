<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PedidosVentaOnline as Pedidos;
use App\Models\Tercero;
use App\Events\PedidosConfirmationPagoRecibidoEvent;
use App\Events\PedidosConfirmationPagoRechazadoEvent;

class PaymentPayuConfirmationController extends Controller
{
    public function  PaymentConfirmation (Request $request)
    {
        //Log::info('PayU Payment Confirmation Received:', $request->all());
      
        $merchantId     = config('company.PAYU_MERCHANT_ID');
        $apiKey         = config('company.PAYU_API_KEY');

        $transactionId  = $request->input('transactionId');
        $statePol       = $request->input('state_pol');
        $referenceSale  = $request->input('reference_sale');
        $value          = $request->input('value');
        $currency       = $request->input('currency');
        $signature      = $request->input('signature');

        // Generar la firma esperada
        $stringSignature    = "$apiKey~$merchantId~$referenceSale~$value~$currency~$statePol";
        $generatedSignature = md5($stringSignature);                                            // O el algoritmo que PayU esté utilizando

        if (strtoupper($signature) === strtoupper($generatedSignature)) {       
            if ($statePol == 4)   $this->PaymentStateUpdatePedido( $request , 1);       // 4 significa "Transacción aprobada"            
            if ($statePol == 6)   $this->PaymentStateUpdatePedido( $request, 0 );       // 6 significa "Transacción rechazada"
        } else {
            Log::info('Eror PaymentConfirmation :', $request);
        }
    }


 
    private function PaymentStateUpdatePedido ($PayuResponse , $SatePol ) {
        $PayReference = $PayuResponse->input('reference_sale');
        $Pedido       = Pedidos::where('payu_reference', $PayReference )->first();

        if (!$Pedido) {
            Log::error("No se encontró el pedido con la referencia: $PayReference ");
            return;
        }

        $Pedido->payu_transaction_id       = $PayuResponse->input('transaction_id');
        $Pedido->payu_transaction_date     = $PayuResponse->input('transaction_date');
        $Pedido->payu_state_pol            = $PayuResponse->input('state_pol');
        $Pedido->payu_cus                  = $PayuResponse->input('cus');
        $Pedido->payu_response_message_pol = $PayuResponse->input('response_message_pol');
        $Pedido->pago_recibido             = $SatePol ;
        $Pedido->save();

        $EmailComprador = $PayuResponse->input('email_buyer');
         
        if ($SatePol == 1) PedidosConfirmationPagoRecibidoEvent::dispatch($Pedido, $EmailComprador );
        if ($SatePol == 0) PedidosConfirmationPagoRechazadoEvent::dispatch($Pedido, $EmailComprador );  ;
        
    }

}