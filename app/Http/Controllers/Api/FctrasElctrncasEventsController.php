<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiSoenac;
use App\Traits\FctrasElctrncasTrait;
use App\Models\FctrasElctrncasEvent   ;
use App\Models\FctrasElctrncasPrvdre;

use Storage;
use Carbon;


class FctrasElctrncasEventsController extends Controller
{
    use FctrasElctrncasTrait, ApiSoenac ;
    private $jsonObject = []  ; 

    public function getFacturasProveedores() {
        return FctrasElctrncasPrvdre::orderBy('fecha')
        ->where('acuse_030','0')
        ->where('rechazo_031','0')
        ->orWhere('recibo_032','0')
        ->orWhere('aceptacion_033','0')
        ->get();
    }


    public function documentStatus ( request $FormData) {
        $partUrl  = 'receptions/' . "$FormData->uuid";
        $response        = $this->ApiSoenac->postRequest( $partUrl, '' ) ;
        return   $response  ;        
    }
    
    public function documentosRecepcionados(  ){
        $partUrl  = 'receptions';
        $response        = $this->ApiSoenac->postRequest( $partUrl, '' ) ;
        return   $response  ;
    }


    public function acuseRecibo(request $FormData) {
        $response = '';
        $partUrl  = 'event/030';
        $Number   = FctrasElctrncasEvent::maxId();
        $this->getJsonAcuse ( $FormData->uuid, $Number  ) ;
        $response        = $this->ApiSoenac->postRequest( $partUrl, $this->jsonObject ) ;
        $isValidResponse = $this->processEventResponse ( $response, $FormData->uuid,'030'  );
      
        $this->eventUpdate('030',$FormData->uuid  );

        return   $response  ;
    }

    public function rechazoReclamo(request $FormData) {
        $response = '';
        $partUrl  = 'event/031';
        $Number   = FctrasElctrncasEvent::maxId();
        $this->getJsonAcuse ( $FormData->uuid, $Number  ) ;
        $response        = $this->ApiSoenac->postRequest( $partUrl, $this->jsonObject ) ;
        $isValidResponse = $this->processEventResponse ( $response, $FormData->uuid, '031'  );
        return   $response['expedition_date'] ;
    }

    public function reciboBienServicio(request $FormData) {
        $response = '';
        $partUrl  = 'event/032';
        $Number   = FctrasElctrncasEvent::maxId();
        $this->getJsonAcuse ( $FormData->uuid, $Number  ) ;
        $response        = $this->ApiSoenac->postRequest( $partUrl, $this->jsonObject ) ;
        $isValidResponse = $this->processEventResponse ( $response, $FormData->uuid, '032'  );

        $this->eventUpdate('032',$FormData->uuid  );

        return   $response ;
    }

    public function aceptacionExpresa(request $FormData) {
        $response = '';
        $partUrl  = 'event/033';
        $Number   = FctrasElctrncasEvent::maxId();
        $this->getJsonAcuse ( $FormData->uuid, $Number  ) ;
        $response        = $this->ApiSoenac->postRequest( $partUrl, $this->jsonObject ) ;
        $isValidResponse = $this->processEventResponse ( $response, $FormData->uuid, '033'  );

        $this->eventUpdate('033',$FormData->uuid  );
        return   $response ;
    }

    public function aceptacionTacitaFacturaVenta( $UUID) {
        /*$response = '';
        $partUrl  = 'event/034';
        $Number   = FctrasElctrncasEvent::maxId();
        $this->getJsonAcuse ( $FormData->uuid, $Number  ) ;
        $response        = $this->ApiSoenac->postRequest( $partUrl, $this->jsonObject ) ;
        $isValidResponse = $this->processEventResponse ( $response, $FormData->uuid, '034'  );

        $this->eventUpdate('034',$FormData->uuid  );
        return   $response ;*/
        return '034 ' . $UUID;
    }


    public function allEvents( request $FormData) {
        $this->acuseRecibo        ( $FormData );
        $this->reciboBienServicio ( $FormData );
        $this->aceptacionExpresa  ( $FormData ); 
    }

    private function eventUpdate ( $Event, $UUID) {
        $Factura                                       = FctrasElctrncasPrvdre::where('cufe',"$UUID")->first();
        if ( $Event ==='030') $Factura->acuse_030      = true;
        if ( $Event ==='032') $Factura->recibo_032     = true;
        if ( $Event ==='033') $Factura->aceptacion_033 = true;
        $Factura->update();
       
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

        $jsonData= [
            'number'      => $Number,
            'uuid'        => $UUID,
            'sync'        => true,
            'person'      => $this->getPersonObject ()
          ] ;
        $this->jsonObject = $jsonData;
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
