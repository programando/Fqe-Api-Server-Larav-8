<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\ApiSoenac;
use App\Traits\PdfsTrait;
use App\Traits\QrCodeTrait;
use App\Traits\FctrasElctrncasTrait;
use App\Traits\DocsSoporteTrait;

use App\Helpers\DatesHelper;
use App\Helpers\GeneralHelper  ;

use App\Models\FctrasElctrnca   ;
use App\Models\FctrasElctrncasErrorsMessage as ErrorResponse   ;
use App\Models\FctrasElctrncasMcipio;
use App\Models\DcmntosSprteWithholdingTaxTotal;
 
use App\Events\InvoiceWasCreatedEvent;


Use Storage;
Use Carbon;


class DcmntosSprteController extends Controller {

    use FctrasElctrncasTrait, ApiSoenac, QrCodeTrait, PdfsTrait, DocsSoporteTrait;
    private $jsonObject = [] , $jsonResponse = []; 


    public function documentosSoporteNotaCredito ( ) {
        $isCreditNote = true;
        $URL        = 'note-document-support' ;
        $Documentos = FctrasElctrnca::DocumentosSoporteNotasToSend();  /// Notas crédito o documentos de anulación
        

        foreach ($Documentos as $Documento ) {
            $this->reportingInformation ( $Documento, $isCreditNote  );  
            return $this->jsonObject;     
            $response   = $this->ApiSoenac->postRequest( $URL, $this->jsonObject) ;            
            $this->traitUpdateJsonObject ( $Documento );
            $this->errorResponse  ( $response , $Documento['id_fact_elctrnca']  );
            $this->successReponse ( $response , $Documento['id_fact_elctrnca']  );
            return $response;
        }    
        
    }


    public function documentosSoporte () {
        $URL        = 'document-support' ;
        $Documentos = FctrasElctrnca::DocumentosSoporteToSend();
         
        foreach ($Documentos as $Documento ) {
            $this->reportingInformation ( $Documento );
            $response   = $this->ApiSoenac->postRequest( $URL, $this->jsonObject) ;  
            $this->traitUpdateJsonObject ( $Documento );
            $this->errorResponse  ( $response , $Documento['id_fact_elctrnca']  );
            $this->successReponse ( $response , $Documento['id_fact_elctrnca']  );

        }
    }


    private function successReponse ( $response, $IdFactElctrnca) {
        if ( $response['is_valid'] == true ) {
            $this->traitDocumentSuccessResponse   ( $IdFactElctrnca, $response );
            $this->traitDocumentSoportReponseSave ( $IdFactElctrnca, $response );
        }
    }


    private function errorResponse ( $response, $IdFactElctrnca) {
        if ( $response['is_valid'] == false ) {
            $Errors   = $response['errors_messages'] ;
            foreach ($Errors as $Error) {
                 $NewError                   = new ErrorResponse ;
                 $NewError->id_fact_elctrnca = $IdFactElctrnca;
                 $NewError->error_message    = $Error;
                 $NewError->fecha            = Carbon::now();
                 $NewError->save();
            }
        }
    }


    private function reportingInformation ( $DocSoporte, $isCreditNote=false  ) {
        $this->jsonObject   = [];
        $id_fact_elctrnca   = $DocSoporte['id_fact_elctrnca'];  
        $otherData          = FctrasElctrnca::with('customer', 'docsSoporteRetenciones', 'total','products','dcmntos_sprte_anulados')->where('id_fact_elctrnca','=', $id_fact_elctrnca)->get(); 
       
        $this->jsonObjectCreate ( $DocSoporte,  $otherData, $isCreditNote  )   ;
   }


   private function jsonObjectCreate ( $DocSoporte, $otherData, $isCreditNote=false  ) {
        if ( $isCreditNote === false ) { // No aplica este encabezado para notas crédito
            $this->DocSoporteHeaderTrait                ( $DocSoporte                               ,  $this->jsonObject    , $DocSoporte['fcha_dcmnto']                 )   ;  
        }else {
            $this->DocNotaSoporteHeaderTrait            ( $DocSoporte,  $this->jsonObject, $otherData[0]['dcmntos_sprte_anulados'] );
            $this->DocNotaSoporteDiscrepancyTrait        ( $DocSoporte,  $this->jsonObject , $DocSoporte['fcha_dcmnto'] ,$otherData[0]['dcmntos_sprte_anulados']    )   ;  
        }
        $this->DocSoporteEnvironmentTrait           ( $this->jsonObject                                                                                              )   ;
        $this->traitCustomer                        ( $otherData[0]['customer']                 , $this->jsonObject                                                  )   ;  
        $this->DocSoporteLegalMonetaryTotalsTrait   ( $otherData[0]['total']                    , $this->jsonObject, 'legal_monetary_totals'                         )   ;
        if ( $isCreditNote === false ) {
            $this->DocSoporteInvoiceLinesTrait          ( $otherData[0]['products']                 , $this->jsonObject, 'invoice_lines' , $DocSoporte['fcha_dcmnto']    )   ; 
        }else{      
            $this->DocSoporteInvoiceLinesTrait          ( $otherData[0]['products']                 , $this->jsonObject, 'credit_note_lines' , $DocSoporte['fcha_dcmnto']    )   ; 
        }
   }




}