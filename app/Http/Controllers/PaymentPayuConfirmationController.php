<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentPayuConfirmationController extends Controller
{
    public function  PaymentConfirmation (Request $request)
    {
        Log::info('PayU Payment Confirmation Received:', $request->all());
        $PayuResponse = $request->all();
        $merchantId = config('company.PAYU_MERCHANT_ID');
        $apiKey     = config('company.PAYU_API_KEY');

        $transactionId = $request->input('transactionId');
        $statePol      = $request->input('state_pol');
        $referenceSale = $request->input('reference_sale');
        $value         = $request->input('value');
        $currency      = $request->input('currency');
        $signature     = $request->input('signature');

        // Generar la firma esperada
        $stringSignature    = "$apiKey~$merchantId~$referenceSale~$value~$currency~$statePol";
        $generatedSignature = md5($stringSignature);                                            // O el algoritmo que PayU esté utilizando

        if (strtoupper($signature) === strtoupper($generatedSignature)) {
            
            if ($statePol == 4)  $this->PaymentStateApprove( $PayuResponse );         // 4 significa "Transacción aprobada"
            if ($statePol == 6) $ $this->PaymentStateRejected( $PayuResponse);        // 6 significa "Transacción rechazada"

        } else {
            $this->PaymentSingError( $PayuResponse ); // Manejar error de firma
        }
    }


    public function PaymentStateApprove ( ) {
        Log::info("Pago aprobado para la referencia: $referenceSale, ID de transacción: $transactionId");
    }


    public function PaymentStateRejected ( ) {
        Log::warning("Pago rechazado para la referencia: $referenceSale, ID de transacción: $transactionId");
    }

    public function PaymentSingError (Request $FormData) {
        Log::error("Firma de PayU inválida para la transacción: $transactionId. Firma recibida: $signature, Firma generada: $generatedSignature");
    }

 

                // // Verificar el estado de la transacción
            // if ($statePol == 4) { // 4 significa "Transacción aprobada"
            //     Log::info("Pago aprobado para la referencia: $referenceSale, ID de transacción: $transactionId");
            //     // Actualizar tu base de datos: marcar el pedido como pagado, etc.
            // } elseif ($statePol == 6) { // 6 significa "Transacción rechazada"
            //     Log::warning("Pago rechazado para la referencia: $referenceSale, ID de transacción: $transactionId");
            //     // Actualizar tu base de datos: marcar el pedido como fallido, etc.
            // } else {
            //     Log::info("Estado de la transacción pendiente o en otro estado: $statePol, referencia: $referenceSale, ID: $transactionId");
            //     // Manejar otros estados según tu lógica de negocio
            // }

            // Registrar los detalles de la transacción en tu base de datos
            // Ejemplo (debes adaptarlo a tus modelos):
            // Payment::create([
            //     'transaction_id' => $transactionId,
            //     'order_reference' => $referenceSale,
            //     'status' => $statePol,
            //     'amount' => $value,
            //     'currency' => $currency,
            //     // Otros campos relevantes
            // ]);



}