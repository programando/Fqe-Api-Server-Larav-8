<?php

namespace App\Listeners;

use App\Events\PedidosConfirmationPagoRecibidoEvent;
use App\Mail\PedidoPagoConfirmadoMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PedidosConfirmationPagoRecibidoListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PedidosConfirmationPagoRecibidoEvent  $event
     * @return void
     */
    public function handle(PedidosConfirmationPagoRecibidoEvent $event)
    {
        try {
            // Obtener emails de configuración
            $emails = [
                config('company.EMAIL_SISTEMAS'),
                config('company.EMAIL_COMERCIAL'),
                config('company.EMAIL_CARTERA'),
                config('company.EMAIL_RECEPCION'),
            ];

            // Filtrar emails válidos
            $emails = array_filter($emails, function($email) {
                return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
            });

            if (empty($emails)) {
                Log::warning('No se encontraron emails válidos para enviar confirmación de pago', [
                    'pedido_id' => $event->pedido->idpddo ?? null
                ]);
                return;
            }

            // Enviar email a cada destinatario
            foreach ($emails as $email) {
                Mail::to($email)->send(new PedidoPagoConfirmadoMail($event->pedido, $event->emailComprador));
                Log::info('Email de confirmación de pago enviado', [
                    'pedido_id' => $event->pedido->idpddo,
                    'email_destino' => $email
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error al enviar email de confirmación de pago', [
                'pedido_id' => $event->pedido->idpddo ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e; // Re-lanzar para que el job falle y se pueda reintentar
        }
    }
}
