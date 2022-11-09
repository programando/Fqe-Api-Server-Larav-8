<?php

namespace App\Listeners;


use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceEventsReportMail;
use App\Events\InvoiceEventsReportEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceEventsReportListener
{
     
   
    public function handle(InvoiceEventsReportEvent $event)
    {
        dd('InvoiceEventsReportListener') ;
        Mail::to( config('company.EMAIL_CONTABILIDAD'))
        ->cc( config('company.EMAIL_AUXCONTABLE') )
        ->cc( config('company.EMAIL_SISTEMAS') )
        ->queue(   new InvoiceEventsReportMail ($event->Factura ));      
    }

}

