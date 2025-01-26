<?php

namespace App\Listeners;

use App\Events\PedidoConfirmacionPagoRecibidoEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PedidoConfirmacionPagoRecibidoListener
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
     * @param  \App\Events\PedidoConfirmacionPagoRecibidoEvent  $event
     * @return void
     */
    public function handle(PedidoConfirmacionPagoRecibidoEvent $event)
    {
        //
    }
}
