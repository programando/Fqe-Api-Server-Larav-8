<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
       'App\Events\InvoiceEventAcptcionTctaCstmerSndEmaiEvent' => ['App\Listeners\InvoiceEventAcptcionTctaCstmerSndEmaiListener',],
       'App\Events\InvoiceEventsReportEvent'                   => ['App\Listeners\InvoiceEventsReportListener',],
       'App\Events\InvoiceWasCreatedEvent'                     => ['App\Listeners\InvoiceSendXmlPdfToCustomer', ],
       'App\Events\InvoiceWasCreatedEventEmailCopy'            => ['App\Listeners\InvoiceSendXmlPdfToCustomerEmailCopy', ],
       'App\Events\NoteWasCreatedEvent'                        => ['App\Listeners\NoteSendXmlPdfToCustomer', ],
       'App\Events\TercerosContactosEvent'                     => ['App\Listeners\TercerosContactosListener', ],
       'App\Events\TercerosNominaWasReportedEvent'             => ['App\Listeners\TercerosNominaWasReportedListener', ],
       'App\Events\UserPasswordResetEvent'                     => ['App\Listeners\UserPasswordReset',],
       'App\Events\UserContactEvent'                           => ['App\Listeners\UserContactListener',],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
