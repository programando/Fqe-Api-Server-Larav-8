<?php

namespace App\Listeners;

use App\Events\PedidosConfirmationPagoRechazadoEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PedidosConfirmationPagoRechazadoListener
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
     * @param  \App\Events\PedidosConfirmationPagoRechazadoEvent  $event
     * @return void
     */
    public function handle(PedidosConfirmationPagoRechazadoEvent $event)
    {
        //
    }
}
