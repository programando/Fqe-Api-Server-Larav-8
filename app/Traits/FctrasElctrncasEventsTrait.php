<?php

namespace App\Traits;

use App\Traits\ApiSoenac;
use App\Models\FctrasElctrncasEvent   ;
use Carbon;
trait FctrasElctrncasEventsTrait {
      use ApiSoenac;
      private $jsonObject = [] ;

  public function FacturaEnviarEventoDian( $CodEven='', $UUID='') {
      $response = '';
      $partUrl  = 'event/'.$CodEven;
      $Number   = FctrasElctrncasEvent::maxId();
      $this->getJsonAcuse ( $UUID, $Number  ) ;
 
      $response        = $this->ApiSoenac->postRequest( $partUrl, $this->jsonObject ) ;
      $isValidResponse = $this->processEventResponse ( $response, $UUID, $CodEven  );

      $this->eventUpdate($CodEven,$UUID );
      return   $response ; 
 
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
      $FctrasElctrncasEvent->fcha_rgstro           = Carbon::now(); ;
      $FctrasElctrncasEvent->event_code            = $CodeEvent;
      $FctrasElctrncasEvent->event_expedition_date = $response['expedition_date'] ;
      $FctrasElctrncasEvent->event_status_message  = $response['status_message'] ;
      $FctrasElctrncasEvent->uuid_document         = $UUIDDoc;
      $FctrasElctrncasEvent->uud_response          = $response['uuid'];  
      $FctrasElctrncasEvent->save();
   }

    private function getJsonAcuse( $UUID, $Number ) {
      $notes[] = ['text'=> 'notas']  ;
      $jsonData= [
          'number'      => $Number,
          'uuid'        => $UUID,
          'notes'       => $notes,
          'sync'        => true,
          'person'      => $this->getPersonObject ()
        ] ;
      $this->jsonObject           = $jsonData;
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

}