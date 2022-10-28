<?php

namespace App\Listeners;

use App\Events\InvoiceEventAcptcionTctaCstmerSndEmaiEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InvoiceEventAcptcionTctaCstmerSndEmaiListener
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
     * @param  \App\Events\InvoiceEventAcptcionTctaCstmerSndEmaiEvent  $event
     * @return void
     */
    public function handle(InvoiceEventAcptcionTctaCstmerSndEmaiEvent $event)
    {
        //
    }
}
