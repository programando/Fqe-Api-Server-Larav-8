<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserAdminSendEmailCodeAccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $AccessCode, $From ;

    public function __construct( $AccessCode )
    {
        $this->AccessCode = $AccessCode ;
        $this->From      = ['address'=> config('company.EMAIL_SISTEMAS'), 'name' => config('company.EMPRESA' )];
    }

 
    public function build()
    {
        return $this->view('mails.terceros.AdminSendAccessCode')
        ->from( $this->From )
        ->subject('Código de acceso al administrador de productos FQE') ;

    }
}
