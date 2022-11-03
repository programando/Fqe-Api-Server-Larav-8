<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\InvoiceEventAcptcionTctaCstmerSndEmailMail;
use App\Events\InvoiceEventAcptcionTctaCstmerSndEmaiEvent;

class InvoiceEventAcptcionTctaCstmerSndEmaiListener
{
 
    public function handle(InvoiceEventAcptcionTctaCstmerSndEmaiEvent $event)
    {
        $Emails         =   $event->FctraAcptdaTctmnte['emails']->unique('email')  ;    
        $when           = now()->addSeconds(15);
        Mail::to( $Emails )
        ->cc( config('company.EMAIL_CONTABILIDAD'))
        ->cc( config('company.EMAIL_AUXCONTABLE') )
        ->cc( config('company.EMAIL_SISTEMAS') )
        ->queue(    new InvoiceEventAcptcionTctaCstmerSndEmailMail ($event->FctraAcptdaTctmnte ));  
  
    }
}
