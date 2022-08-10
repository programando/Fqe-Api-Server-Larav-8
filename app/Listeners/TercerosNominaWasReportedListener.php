<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use App\Mail\TercerosNominaWasReported;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\TercerosNominaWasReportedEvent;
use config;
class TercerosNominaWasReportedListener
{
  
    public function handle(TercerosNominaWasReportedEvent $event)
    {
         Mail::to( config('company.CONTABILIDAD'))
          ->cc( config('company.EMAIL_SISTEMAS') )
          ->queue(   new TercerosNominaWasReported ($event->Empleados ));
    }
}
