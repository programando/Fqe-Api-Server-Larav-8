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
        
            
        try {
            $merchantId     = config('company.PAYU_MERCHANT_ID');
            $apiKey         = config('company.PAYU_API_KEY');

            $transactionId  = $request->input('transaction_id'); // ojo, es transaction_id (guion bajo)
            $statePol       = $request->input('state_pol');
            $referenceSale  = $request->input('reference_sale');
            $value          = $request->input('value');
            $currency       = $request->input('currency');
            $signature      = $request->input('sign'); // PayU envía "sign", no "signature"

            // ⚠️ PayU a veces envía decimales con o sin ceros: "128300.00" vs "128300"
            // debes normalizar el valor a dos decimales antes de firmar:
            $valueFormatted = number_format($value, 1, '.', '');

            // Generar firma esperada
            $stringSignature    = "$apiKey~$merchantId~$referenceSale~$valueFormatted~$currency~$statePol";
            $generatedSignature = md5($stringSignature);

            Log::info('Generated signature: ' . $generatedSignature);
            Log::info('Received signature: ' . $signature);

            if (strtoupper($signature) === strtoupper($generatedSignature)) {
                if ($statePol == 4) {
                    $this->PaymentStateUpdatePedido($request, 1); // Aprobada
                } elseif ($statePol == 6) {
                    $this->PaymentStateUpdatePedido($request, 0); // Rechazada
                }
            } else {
                Log::error("Firma inválida para referencia $referenceSale. Esperada: $generatedSignature, Recibida: $signature");
            }

        } catch (\Throwable $e) {
            Log::error("Error PaymentConfirmation: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
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