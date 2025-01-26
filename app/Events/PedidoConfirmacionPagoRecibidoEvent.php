<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PedidoConfirmacionPagoRecibidoEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $Pedido, $PedidoDt;

    public function __construct( $Pedido )    {
        $this->Pedido   = $Pedido;
        $this->PedidoDt = $Pedido->PedidoDt;
    }
 

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

}
