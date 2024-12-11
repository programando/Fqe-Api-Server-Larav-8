<?php

namespace App\Listeners;

use App\Events\UserAdminSendEmailCodeAccessEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\UserAdminSendEmailCodeAccessMail;
use Illuminate\Support\Facades\Mail;

class UserAdminSendEmailCodeAccessListener
{
    
    public function handle(UserAdminSendEmailCodeAccessEvent $event)
    {
         
             Mail::to($event->Email)
              ->queue(   new UserAdminSendEmailCodeAccessMail ($event->AccessCode));
        
    }
}
