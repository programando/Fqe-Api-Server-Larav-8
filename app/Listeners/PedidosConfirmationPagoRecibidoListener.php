<?php

namespace App\Listeners;

use App\Events\PedidosConfirmationPagoRecibidoEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PedidosConfirmationPagoRecibidoListener
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
        //
    }
}
