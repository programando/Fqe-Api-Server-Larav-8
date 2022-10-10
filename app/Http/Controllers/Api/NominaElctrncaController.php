<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;

use App\Events\TercerosNominaWasReportedEvent;

use App\Helpers\DatesHelper;
use App\Helpers\GeneralHelper  ;

use App\Http\Controllers\Controller;

use App\Models\NominaElctrncaXmlSequenceNumber as Nomina;

use App\Traits\ApiSoenac;
use App\Traits\NominaElctrncaTrait;
use App\Traits\PdfsTrait;
use App\Traits\QrCodeTrait;



Use Storage;
Use Carbon;
use config;
class NominaElctrncaController extends Controller
{
       use  ApiSoenac, QrCodeTrait, PdfsTrait, NominaElctrncaTrait;
       private $jsonObject = [] , $jsonResponse = [], $employeeObject = [];

       
       public function zipKey ($ZipKey) {
             $URL                         = "ubl2.1/status/zip/$ZipKey"  ;   
             $requestNomina               = true ;
             $this->jsonObject['environment']['url']     = 'https://vpfe-hab.dian.gov.co/WcfDianCustomerServices.svc?wsdl'  ;
             $response                    = $this->ApiSoenac->postRequest( $URL, $this->jsonObject, $requestNomina ) ; 
             $this->documentsProcessReponse( '365', $response ) ;
             return $response;
       }
       
       
       public function dianReporting () {
              $URL           = 'payroll/102'  ;
              $requestNomina = true ;
              $Empleados     = Nomina::dianReporting();
              
              foreach ($Empleados as $Empleado ) {
                  $this->reportingInformation ( $Empleado );
                  $response   = $this->ApiSoenac->postRequest( $URL, $this->jsonObject, $requestNomina ) ;  
                  $this->documentsProcessReponse( $Empleado['id_nomina_elctrnca'], $response ) ;
                  //return $response;
              }
             // Informa a empresa repote de nómina 
             if ( $Empleados ) {
                TercerosNominaWasReportedEvent::dispatch ( $this->employeeObject);
             }
       }

       public function notaAjusteNomina () {
              $this->jsonObject['sync'] = true;
              $this->traitEnvironment            ( $this->jsonObject                                             ) ;
              $payroll_reference =[
                            "number"     => "NOM427",
                            "uuid"       => "74381d002b6475bf65d518f3889c025c863c8dcbf5ea2f305666b0a5d56d7dbeb75359de3a00731a9b382a3738473af4",
                            "issue_date" => "2021-10-14"
              ];
              $xml_sequence_number =[
                            "prefix"=> "NOM",
                            "number"=>455
              ];
              $general_information =["payroll_period_id"=> "5",  ];    
                     
              $this->jsonObject['type_payroll_note_id'] = '2' ;
              $this->jsonObject['payroll_reference']    = $payroll_reference;
              $this->jsonObject['xml_sequence_number']  = $xml_sequence_number;
              $this->jsonObject['general_information']  = $general_information;
              $this->traitEmployer               ( $this->jsonObject                                             ) ;
              $URL                 = 'payroll/103'  ;
              $requestNomina       = true ;
              $response            = $this->ApiSoenac->postRequest( $URL, $this->jsonObject, $requestNomina ) ; 
              return  $response  ;
       }

       private function reportingInformation ( $Empleado ) {
            $this->jsonObject   = [];
            $id_nomina_elctrnca = $Empleado['id_nomina_elctrnca'];    
            $otherData          = Nomina::with('generalInformation', 'employee', 'period','payment','earns','deductions')->where('id_nomina_elctrnca','=', $id_nomina_elctrnca)->get();  
            $this->jsonObjectCreate ( $Empleado,  $otherData  )   ;
       }

       private function jsonObjectCreate ( $Empleado, $otherData ) {
              $this->traitXmlSequenceNumber      ( $Empleado                             ,  $this->jsonObject                           ) ;
              $this->traitEnvironment            ( $this->jsonObject                                                                    ) ;
              $this->traitXmlProvider            ( $this->jsonObject                                                                    ) ;
              $this->traitGeneralInformation     ( $otherData[0]['generalInformation']   ,  $this->jsonObject                           ) ;
              $this->traitEmployer               ( $this->jsonObject                                                                    ) ;
              $this->traitEmployee               ( $otherData[0]['employee']             ,  $this->jsonObject, $this->employeeObject    ) ;
              $this->traitPeriod                 ( $otherData[0]['period']               ,  $this->jsonObject                           ) ;
              $this->traitPayment                ( $otherData[0]['payment']              ,  $this->jsonObject                           ) ;
              $this->traitPaymentDates           ( $otherData[0]['period']               ,  $this->jsonObject                           ) ;
              $this->traitEarBasic               ( $otherData[0]['earns']                ,  $this->jsonObject                           ) ;
              $this->traitDeductions             ( $otherData[0]['deductions']           ,  $this->jsonObject                           ) ;
              $this->traitTotals                 ( $Empleado                             ,  $this->jsonObject                           ) ;
       }


        private  function documentsProcessReponse($id_nomina_elctrnca,  $response ){

            if ( array_key_exists('is_valid',$response) ) {
                $this->responseContainKeyIsValid ( $id_nomina_elctrnca, $response );                 
            } //else {       
                //$this->traitdocumentErrorResponse( $id_nomina_elctrnca, $response ); 
            //}
        }

    private function responseContainKeyIsValid($id_nomina_elctrnca , $response ){
             
        if ( $response['is_valid'] == true || is_null( $response['is_valid'] ) ) {
            $this->traitDocumentSuccessResponse ( $id_nomina_elctrnca , $response );
        } //else {
            //$this->traitdocumentErrorResponse( $id_nomina_elctrnca, $response );     
        //}
    }


}
