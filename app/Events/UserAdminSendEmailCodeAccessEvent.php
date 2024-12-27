<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserAdminSendEmailCodeAccessEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $Email, $AccessCode;

    public function __construct( $Email, $AccessCode )   {
        $this->Email = $Email;
        $this->AccessCode = $AccessCode;

    }

}
