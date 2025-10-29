<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PedidosConfirmationPagoRecibidoEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pedido;
    public $emailComprador;

    /**
     * Create a new event instance.
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
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
