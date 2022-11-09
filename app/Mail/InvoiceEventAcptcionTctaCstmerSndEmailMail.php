<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceEventAcptcionTctaCstmerSndEmailMail extends Mailable
{
    use Queueable, SerializesModels;
    public $NumeroFactura, $Prefijo, $UrlConsultaEvento;
    public function __construct( $Factura)
    {
        $this->NumeroFactura     = $Factura['number'];
        $this->Prefijo           = $Factura['prfjo_dcmnto'];
        $this->UrlConsultaEvento = config('company.DOCUMENTO_URL_CONSULTA_CUFE') .$Factura['uuid'];
             
    }

    public function build()
    {
        return $this->view('mails.invoices.InvoicesEventsAceptacionTacita')
        ->from( config('company.EMAILS_CONTACTOS') )
        ->subject('FQE-SAS - Aceptación tácita factura de venta') ; 
    }
}
