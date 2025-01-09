<?php

namespace App\Traits;

use Carbon;
use App\Traits\ApiSoenac;
use App\Models\FctrasElctrnca   ;

use App\Models\FctrasElctrncasPrvdre;
use App\Models\FctrasElctrncasEvent   ;

trait FctrasElctrncasEventsTrait {
      use ApiSoenac;
      private $jsonObject = [] ;

  public function FacturaEnviarEventoDian( $CodEven='', $FacturaCliente, $EsFacturaCliente = true ) {
      $UUID        = $FacturaCliente['uuid'];
      $InvoceNumer = $FacturaCliente['prfjo_dcmnto'].$FacturaCliente['number'];
      $response    = '';
      $partUrl     = 'event/'.$CodEven;
      $Number      = FctrasElctrncasEvent::maxId();
       
      $this->getJsonAcuse ( $UUID, $Number, $CodEven, $FacturaCliente['customer'] , $InvoceNumer ) ;
      $response        = $this->ApiSoenac->postRequest( $partUrl, $this->jsonObject ) ;
      
      if ( $EsFacturaCliente  === false ) {                               
        $this->processEventResponse ( $response, $UUID, $CodEven  );    //TODO -> SOLO PARA FACTURAS DE PROVEEDOR
        $this->eventUpdate($CodEven,$UUID, $EsFacturaCliente  );
        return  $response ; 
      }
      $this->saveNewResponse   ( $response, $UUID,$CodEven );
      return  $response ; 
    }


    private function processEventResponse ( $response, $UUID, $CodeEvent ) {
      if ( array_key_exists('is_valid',$response) && $response['is_valid'] == true) {
           $this->saveNewResponse   ( $response, $UUID,$CodeEvent );
       } else {
           return "error";
       }
   }


   private function saveNewResponse ( $response, $UUIDDoc, $CodeEvent) {    
      $FctrasElctrncasEvent                        = new FctrasElctrncasEvent;
      $FctrasElctrncasEvent->fcha_rgstro           = Carbon::now();  
      $FctrasElctrncasEvent->event_code            = $CodeEvent;
      $FctrasElctrncasEvent->event_expedition_date = $response['expedition_date'] ;
      $FctrasElctrncasEvent->event_status_message  = $response['status_message'] ;
      $FctrasElctrncasEvent->uuid_document         = $UUIDDoc;
      $FctrasElctrncasEvent->uud_response          = $response['uuid'];  
      $FctrasElctrncasEvent->save();
   }

    private function getJsonAcuse( $UUID, $Number, $CodEven,  $FacturaCliente , $InvoceNumer) {
      $notes[] = []  ;
      $jsonData= [
          'number'      => $Number,
          'uuid'        => $UUID,
          'notes'       => $notes,
          'sync'        => true,
          'person'      => $this->getPersonObject ()
        ] ;
      $this->jsonObject           = $jsonData;
      $this->setNotes ($CodEven,$UUID,  $FacturaCliente, $InvoceNumer  );
      
      return  $this->jsonObject ;
  }

  private function setNotes ($CodEven,$UUID, $FacturaCliente, $InvoceNumer ){
    
    $CustomerName = $FacturaCliente['name'];
    $CustomerNit  = $FacturaCliente['identification_number'];

    $notes[] = ['text'=> 'Manifiesto bajo la gravedad de juramento que transcurridos 3 días hábiles contados desde la creación del recibo de bienes y servicios ' . $InvoceNumer. ' con CUDE '."$UUID".', el adquirente ' . $CustomerName . ' identificado con NIT ' . $CustomerNit .' no manifestó expresamente la aceptación o rechazo de la referida factura, ni reclamó en contra de su contenido.']  ;
    $this->jsonObject['notes']  = $notes;
  }

  private function getPersonObject() {
      return  [
          "type_document_identification_id" => '3',
          "identification_number"           => '5275411',
          "first_name"                      => 'LILIBETH',
          "family_name"                     => "VIELMA",
          "job_title"                       => "N/A",
          "organization_department"         => "N/A"
      ];

  }


  private function eventUpdate ( $Event, $UUID, $EsFacturaCliente = false)  {
    if ($EsFacturaCliente === false) {
          $Factura                                       = FctrasElctrncasPrvdre::where('cufe',"$UUID")->first();
          if ( $Event ==='030') $Factura->acuse_030      = true;
          if ( $Event ==='032') $Factura->recibo_032     = true;
          if ( $Event ==='033') $Factura->aceptacion_033 = true;
          $Factura->update();
    }


   
}

}