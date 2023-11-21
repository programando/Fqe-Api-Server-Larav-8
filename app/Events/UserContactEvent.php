<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserContactEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
 
    public $cargo, $correo, $mensaje, $nombre, $pais, $telefono;
    public function __construct( $FormData )
    {
        $this->cargo    = $FormData->cargo ;
        $this->correo   = $FormData->correo ;
        $this->mensaje  = $FormData->mensaje ;
        $this->nombre   = $FormData->nombre ;
        $this->pais     = $FormData->pais ;
        $this->telefono = $FormData->telefono ;
    }

 
}
