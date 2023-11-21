<?php

namespace App\Listeners;

use App\Events\UserContactEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\TercerosContactanosMail;
use Illuminate\Support\Facades\Mail;
use config;

class UserContactListener
{
      public function handle(UserContactEvent $event)
    {
         Mail::to( config('company.EMAIL_COMERCIAL'))
          ->cc( config('company.EMAIL_LOGISTICA') )
          ->queue(   new TercerosContactanosMail ($event));
    }
}

   