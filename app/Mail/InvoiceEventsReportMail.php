<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceEventsReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $from,  $BodyTable;

    public function __construct( $Factura)
    {
        
        //$this->from      = ['address'=> config('company.EMAIL_SISTEMAS'), 'name' => config('company.EMPRESA' )];
        $this->BodyTable =  $this->getTableHTML ($Factura );     
        dd('InvoiceEventsReportMail') ;  
    }

  
    public function build()
    {
        return $this->view('mails.invoices.InvoicesEventsReport')
                    ->from( config('company.EMAILS_CONTACTOS') )
                    ->subject('Reporte eventos facturas de venta') ;             
    }


    private function getTableHTML ($Facturas) {
        $Tabla = '';
        $Num   = 1;

        foreach ($Facturas  as $Factura) {
               
                $Tabla = $Tabla ."<tr>"  ;
                    $Tabla = $Tabla . "<td>" . $Num                                               . "</td>" ;
                    $Tabla = $Tabla . "<td>" . date_format($Factura['fcha_dcmnto'], 'd/m/Y')      . "</td>" ;
                    $Tabla = $Tabla . "<td>" . $Factura['prfjo_dcmnto']. $Factura['nro_dcmnto']   . "</td>" ; 
                    $Tabla = $Tabla . "<td>" . trim($Factura['name'])                             . "</td>" ;
                    $Tabla = $Tabla . "<td style='text-align: center;font-weight: bold;'>" . trim($Factura['response_code_030'] )               . "</td>" ;
                    $Tabla = $Tabla . "<td style='text-align: center;font-weight: bold;'>" . trim($Factura['response_code_032'] )               . "</td>" ;
                    $Tabla = $Tabla . "<td style='text-align: center;font-weight: bold;'>" . trim($Factura['response_code_033'] )               . "</td>" ;
                    $Tabla = $Tabla . "<td style='text-align: center;font-weight: bold;'>" . trim($Factura['response_code_034'] )               . "</td>" ;
                    $Tabla = $Tabla . "<td style='text-align: center;font-weight: bold;color: #FF0000;'>" . trim($Factura['response_code_031'] )               . "</td>" ;
                $Tabla = $Tabla . '</tr>';
                $Num++;
        } 
        return   $Tabla;
    }

}
