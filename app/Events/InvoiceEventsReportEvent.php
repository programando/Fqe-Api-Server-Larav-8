<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceEventsReportEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $Factura ;
      
    public function __construct( $Factura )
    {
        $this->Factura      = $Factura ;
    }

 
}