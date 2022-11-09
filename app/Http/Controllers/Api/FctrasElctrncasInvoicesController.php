<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;


use App\Events\InvoiceEventAcptcionTctaCstmerSndEmaiEvent;
use App\Events\InvoiceEventsReportEvent;
use App\Events\InvoiceWasCreatedEvent;
use App\Events\InvoiceWasCreatedEventEmailCopy;

use App\Helpers\DatesHelper;
use App\Helpers\GeneralHelper  ;


use App\Http\Controllers\Api\FctrasElctrncasEventsController;
use App\Models\FctrasElctrnca   ;
use App\Models\FctrasElctrncasDataResponse as DataResponse ;   ;
use App\Models\FctrasElctrncasMcipio;

use App\Traits\ApiSoenac;
use App\Traits\FctrasElctrncasEventsTrait;
use App\Traits\FctrasElctrncasTrait;
use App\Traits\PdfsTrait;
use App\Traits\QrCodeTrait;
use Illuminate\Http\Request;

Use Storage;
Use Carbon;
use config;

class FctrasElctrncasInvoicesController  
{
   use FctrasElctrncasTrait, ApiSoenac, QrCodeTrait, PdfsTrait, FctrasElctrncasEventsTrait;

   private $jsonObject = [] , $jsonResponse = [];
  

       public function  InvoicesGestionEventos ( ) {
            $Facturas = $this->InvoicesEventosConsultaGetData () ;
            $this->InvoiceGestionEventosCodificacion              ( $Facturas ) ;
            
            InvoiceEventsReportEvent::dispatch                    ( $Facturas ) ;  
            
            $this->InvoicesGestionEventosSetAceptactionTacita     ( $Facturas );
            $this->InvoicesGestionEventosSetAceptactionExpresa    ( $Facturas );
            //return $Facturas ;
        }

        private function InvoicesGestionEventosSetAceptactionExpresa ($Facturas) {
            $TipoAceptacion='CLIEN';
            foreach( $Facturas as $Factura ) {
                if ( $Factura['response_code_033'] === 'Ok' ) { 
                    $FacturaPorAceptar = FctrasElctrnca::with( 'emails')->where('id_fact_elctrnca','=', $Factura['id_fact_elctrnca'])->first();
                    $this->facturaSetAceptacionTacita   ( $FacturaPorAceptar,  $TipoAceptacion                                            ) ;    //  MARCAR FACURA  
                }
            }
    }


        private function InvoicesGestionEventosSetAceptactionTacita ($Facturas) {
                $TipoAceptacion='TACIT';
                foreach( $Facturas as $Factura ) {
                    if ( $Factura['acptcion_tcta'] === 'SI' ) { 
                        $FacturaPorAceptar = FctrasElctrnca::with( 'emails', 'customer')->where('id_fact_elctrnca','=', $Factura['id_fact_elctrnca'])->first();
                         $this->FacturaEnviarEventoDian      ('034',  $FacturaPorAceptar                 ) ;    // GENERAR EVENTO Trait       
                         $this->facturaSetAceptacionTacita   ( $FacturaPorAceptar,  $TipoAceptacion      ) ;    //  MARCAR FACURA
                        InvoiceEventAcptcionTctaCstmerSndEmaiEvent::dispatch ($FacturaPorAceptar         ) ;    //  ENVIAR CORREO
                    }
                }
        }

 
        private function facturaSetAceptacionTacita ( $Factura, $TipoAceptacion  ) {
            $Factura->dcment_acptcion      = 1;
            $Factura->note_dcment_acptcion = $TipoAceptacion ;
            $Factura->fcha_dcment_acptcion = Carbon::now();
            $Factura->save();
        }

        private function InvoiceGestionEventosCodificacion ( &$Facturas) {       
                $PosI = 0;
                $Hoy = Carbon::now()->format('Y-m-d h:m:s'); 
                $AceptacionExpresa = false;
                foreach ($Facturas as $Evento  ) { 
                    foreach ($Evento['events'] as $ResponsesCodes ) {
                        $CodEvento = trim($ResponsesCodes['response_code']);
                        if ($CodEvento ==='030' ) $Facturas[$PosI]['response_code_030'] = 'Ok';
                        if ($CodEvento ==='031' ) $Facturas[$PosI]['response_code_031'] = 'RECHAZADA';
                        if ($CodEvento ==='032' ) $Facturas[$PosI]['response_code_032'] = 'Ok';
                        if ($CodEvento ==='034' ) $Facturas[$PosI]['response_code_034'] = 'Ok';
                        if ($CodEvento ==='033' ) {
                            $Facturas[$PosI]['response_code_033'] = 'Ok';
                            $AceptacionExpresa = true;
                        } 
                        if ( $Hoy > $Facturas[$PosI]['fcha_acptcion_exprsa'] AND $AceptacionExpresa === false ) {
                            $Facturas[$PosI]['acptcion_tcta'] = 'SI';
                        }
                    }
                    $PosI++;
                };
                return $Facturas;
            }

        

        private function InvoicesEventosConsultaGetData () {
            $ResponseEvents = [];
            $Hoy = Carbon::now()->format('Y-m-d h:m:s'); 

            $Documentos = FctrasElctrnca::InvoicesPendientesAceptacionExpresa(); 

            $this->traitPendientesAceptacionExpresaSetEnvironment ($this->jsonResponse);
             
            foreach($Documentos as $Factura )  {
                $URL          = 'status/events/'.$Factura['uuid'] ;
                $response     = $this->ApiSoenac->postRequest( $URL, $this->jsonObject) ; 
                $data=[
                    "id_fact_elctrnca"     => $Factura['id_fact_elctrnca'],
                    "prfjo_dcmnto"         => $Factura['prfjo_dcmnto'],
                    "nro_dcmnto"           => $Factura['nro_dcmnto'],
                    "fcha_dcmnto"          => $Factura['fcha_dcmnto'],
                    "fcha_acptcion_exprsa" => $Factura['fcha_acptcion_exprsa'],
                    "acptcion_tcta"        => 'NO' ,    //$Hoy > $Factura['fcha_acptcion_exprsa'] ? "SI" : "NO",
                    "rechazada"            => "NO",
                    "uuid"                 => $Factura['uuid'],
                    "name"                 => $Factura['customer']['name'],
                    "is_valid"             => $response['is_valid'],
                    "status_code"          => $response['status_code'],
                    "error_messages"       => $response['error_messages'],
                    "status_message"       => $response['status_message'],
                    "status_description"   => $response['status_description'],
                    "response_code_030"    => '',                                             //acuse de recibo de factura electrónica de venta.
                    "response_code_031"    => '',                                             //reclamo de la factura electrónica de venta
                    "response_code_032"    => '',                                             //recibo del bien y/o prestación del servicio.
                    "response_code_033"    => '',                                             //aceptación expresa
                    "response_code_034"    => '',                                             //aceptación tácita.
                    "events"               => $response['events'],
                    
                ];
               array_push ( $ResponseEvents,$data);               
            }
            return $ResponseEvents;
        }




        public function sentInvoicesLogs (Request $FormData) {
            $prfjo_dcmnto = trim( $FormData->prfjo_dcmnto);
            $nro_dcmnto   = $FormData->nro_dcmnto;
            $partUrl      = "logs/$prfjo_dcmnto$nro_dcmnto";
            $response     = $this->ApiSoenac->postRequest( $partUrl, $this->jsonResponse ) ;   
            $Documento    = FctrasElctrnca::where('prfjo_dcmnto', "$prfjo_dcmnto")
                                            ->where('nro_dcmnto',$nro_dcmnto  ) ->first();
            DataResponse::where('id_fact_elctrnca', $Documento['id_fact_elctrnca'])->delete();
            $this->documentsProcessReponse( $Documento, $response[0] ) ;
            return $Documento['id_fact_elctrnca'];
        }


        public function invoices() {
            $URL = 'invoice'  ;
            $Documentos = FctrasElctrnca::InvoicesToSend()->get();       
            foreach ($Documentos as $Documento ) {
                $this->invoicesToSend ( $Documento) ;    
                $response   = $this->ApiSoenac->postRequest( $URL, $this->jsonObject ) ;    
                $this->traitUpdateJsonObject ( $Documento );
                $this->documentsProcessReponse( $Documento, $response ) ;
                 //return $this->jsonObject;
            }  
        }

        private function invoicesToSend ($Facturas)  {
            $this->jsonObject = [];
            $id_fact_elctrnca = $Facturas['id_fact_elctrnca'];    
            $otherDataInvoice = FctrasElctrnca::with('customer','total', 'products', 'emails')->where('id_fact_elctrnca','=', $id_fact_elctrnca)->get();
            $this-> jsonObjectCreate ($Facturas , $otherDataInvoice     );
        }

        private function jsonObjectCreate ( $invoce,  $Others ) {
                $this->traitDocumentHeader              ( $invoce                , $this->jsonObject   );
                $this->traitEmailSend                   ( $Others[0]['emails']   , $this->jsonObject   );
                $this->traitNotes                       ( $invoce                , $this->jsonObject   );
                $this->traitOrderReference              ( $invoce                , $this->jsonObject   );
                $this->traitReceiptDocumentReference    ( $invoce                , $this->jsonObject   );
                $this->traitCustomer                    ( $Others[0]['customer'] , $this->jsonObject   );
                $this->traitPaymentForms                ( $invoce                , $this->jsonObject   );
                $this->traitLegalMonetaryTotals         ( $Others[0]['total']    , $this->jsonObject, 'legal_monetary_totals' );
                $this->traitInvoiceLines                ( $Others[0]['products'] , $this->jsonObject, 'invoice_lines'   );
                unset( $this->jsonObject['billing_reference']);
                unset( $this->jsonObject['discrepancy_response']);// No los necesito para facturas
            }

 

        
        private  function documentsProcessReponse($Documento,  $response ){
            $id_fact_elctrnca           = $Documento['id_fact_elctrnca']  ;
           
            if ( array_key_exists('is_valid',$response) ) {
                $this->responseContainKeyIsValid ( $id_fact_elctrnca, $response );                 
            } else {       
                $this->traitdocumentErrorResponse( $id_fact_elctrnca, $response ); 
            }
        }

    private function responseContainKeyIsValid($idfact_elctrnca , $response ){
             
        if ( $response['is_valid'] == true || is_null( $response['is_valid'] ) ) {
            $this->traitDocumentSuccessResponse ( $idfact_elctrnca , $response );
            $this->invoiceSendToCustomer  ( $idfact_elctrnca ); 
        }else {
            $this->traitdocumentErrorResponse( $idfact_elctrnca, $response );     
        }
    }

       public function invoiceSendToCustomer ( $id_fact_elctrnca ) {
          $Factura      = $this->invoiceSendGetData ( $id_fact_elctrnca) ; 
          InvoiceWasCreatedEvent::dispatch          ( $Factura ) ; 
       }


        private function invoiceSendGetData ( $id_fact_elctrnca ) {
             $Factura = FctrasElctrnca::with('customer','total', 'products', 'emails','additionals', 'serviceResponse')->where('id_fact_elctrnca','=', $id_fact_elctrnca)->get();
             $Factura = $Factura[0];
            $this->getNameFilesTrait($Factura );
            $this->invoiceCreateFilesToSend  ( $id_fact_elctrnca,  $Factura  );
            return $Factura;
        }

        public function invoiceFileDownload ( $fileType, $id_fact_elctrnca ) {
            $this->invoiceSendGetData ( $id_fact_elctrnca) ;
            if ( strtoupper( $fileType) == 'PDF') {
                return response()->download( Storage::disk('Files')->path( $this->PdfFile ) )->deleteFileAfterSend();
            }else {
                return response()->download( Storage::disk('Files')->path( $this->XmlFile ) )->deleteFileAfterSend();
            }
        }

        private function invoiceCreateFilesToSend ( $id_fact_elctrnca,  $Factura  ){
            $Resolution   = $this->traitSoenacResolutionsInvoice();                
            $this->saveInvoicePfdFile   ( $Resolution, $Factura );
            $this->saveInvoiceXmlFile   ( $Factura              );
        }

        private function saveInvoicePfdFile  ( $Resolution, $Factura   ){           
            $Fechas          = $this->FechasFactura ( $Factura['fcha_dcmnto'], $Factura['due_date'] );
            $Customer        = $Factura['customer'];
            $Products        = $Factura['products'];
            $Totals          = $Factura['total'];
            $Additionals     = $Factura['additionals'];
            $ServiceResponse = $Factura['serviceResponse'];
            $CantProducts    = $Products->count();         
            $CodigoQR        = $this->QrCodeGenerateTrait( $ServiceResponse['qr_data'] );
            $Data            = compact('Resolution', 'Fechas', 'Factura','Customer', 'Products','CantProducts', 'Totals','CodigoQR', 'Additionals' );
            $PdfContent      = $this->pdfCreateFileTrait('pdfs.invoice', $Data);
            Storage::disk('Files')->put( $this->PdfFile, $PdfContent);
        }

        private function saveInvoiceXmlFile ( $Factura) {
            $Factura      = $Factura['serviceResponse'];
            $base64_bytes = $Factura['attached_document_base64_bytes'];
            Storage::disk('Files')->put( $this->XmlFile, base64_decode($base64_bytes));
        }

        private function FechasFactura ( $FechaFactura, $FechaVencimiento) {
            $Fechas       = [];
            $fechaInicial = Carbon::parse($FechaFactura);
            $diasCredito  = $fechaInicial->diffInDays($FechaVencimiento)+1;
            $diasCredito  = $diasCredito > 1 ? " - $diasCredito días" : '';
            $FechaFactura = DatesHelper::DocumentDate( $FechaFactura  );
            $FechaVcmto   = DatesHelper::DocumentDate( $FechaVencimiento  );
            $Fechas = [
                'FactDia'     => $FechaFactura->day,
                'FactMes'     => GeneralHelper::nameOfMonth( $FechaFactura->month),
                'Factyear'    => $FechaFactura->year,
                'VenceDia'    => $FechaVcmto->day,
                'VenceMes'    => GeneralHelper::nameOfMonth( $FechaVcmto->month),
                'VenceYear'   => $FechaVcmto->year,
                'diasCredito' => $diasCredito
            ];
            return $Fechas;
        }

        public function invoiceAccepted ( $Token ) {          
            $this->customerResponse ( $Token, 'ACEPTADA');
            return redirect('/');
        }

        public function invoiceRejected ( $Token  ){
            $this->customerResponse ( $Token, 'RECHAZADA');
            return redirect('/');
        }
 
 
        private function customerResponse ( $Token, $Reponse ) {
            $Factura      = FctrasElctrnca::where('cstmer_token', "$Token")->first();
            if ( !empty( $Factura['cstmer_rspnse'] ) ) {
                $Factura->cstmer_rspnse      = $Reponse;
                $Factura->cstmer_rspnse_date = now();
                $Factura->update();
            } 
        }


 
 
}
