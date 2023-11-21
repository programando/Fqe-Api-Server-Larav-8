<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use config;

class TercerosContactanosMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cargo, $correo, $mensaje, $nombre, $pais, $telefono;
    public function __construct( $FormData)
    {
        $this->cargo    = $FormData->cargo ;
        $this->correo   = $FormData->correo ;
        $this->mensaje  = $FormData->mensaje ;
        $this->nombre   = $FormData->nombre ;
        $this->pais     = $FormData->pais ;
        $this->telefono = $FormData->telefono ;      
    }




    public function build()
    {
        return $this->view('mails.terceros.contactos')
        ->from( $this->correo , 'Contactos - sitio web')
        ->subject('Contactos - sitio web') ;
    }
}
