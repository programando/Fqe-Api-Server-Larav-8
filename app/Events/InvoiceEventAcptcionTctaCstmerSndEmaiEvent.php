<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceEventAcptcionTctaCstmerSndEmaiEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $FctraAcptdaTctmnte;
    public function __construct( $Factura )
    {
        $this->FctraAcptdaTctmnte = $Factura ;
    }


}
