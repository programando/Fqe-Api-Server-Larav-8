<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PedidoPagoConfirmadoMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $pedido;
    public $emailComprador;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\PedidosVentaOnline $pedido
     * @param string $emailComprador
     * @return void
     */
    public function __construct($pedido, $emailComprador)
    {
        $this->pedido = $pedido;
        $this->emailComprador = $emailComprador;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirmación de Pago Recibido - Pedido #' . $this->pedido->idpddo)
                    ->view('mails.pedidos.pago-confirmado');
    }
}