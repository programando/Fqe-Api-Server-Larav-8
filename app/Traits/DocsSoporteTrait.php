<?php

namespace App\Traits;
 
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\FctrasElctrnca;
use Illuminate\Support\Facades\Hash;

use App\Helpers\DatesHelper as Fecha;
use App\Helpers\NumbersHelper as Numbers;
use App\Helpers\StringsHelper as Strings;
use App\Models\FctrasElctrncasDataResponse;
use App\Models\FctrasElctrncasSoportDocumentResponse as DocSoporteResponse;



trait DocsSoporteTrait {
    
    protected $PdfFile, $XmlFile, $DocumentNumber;
    
    

    protected function DocSoporteHeaderTrait($Document , &$jsonObject, $FechaTransacion  ) {      
        $jsonObject= [
            'number'            => $Document["number"],
            'type_document_id'  => $Document["type_document_id"],
            'type_operation_id' => $Document["type_operation_id"],
            'resolution_id'     => 4,
            'sync'              => true,
            'date'              => Fecha::YMD( $FechaTransacion)
            ] ;
        }

    protected function DocNotaSoporteHeaderTrait($Document , &$jsonObject, $Anulados  ) {
        $discrepancy_response = array('discrepancy_response' => 2);
        $number = array (
            'number'               => $Document["number"],
            'type_operation_id'    => $Document["type_operation_id"],
            'type_document_id'     => $Document["type_document_id"],
            'sync'                 => true,
            'resolution_id'        => 4,
            'discrepancy_response' => $discrepancy_response
        );

            $jsonObject = $number;
    }

    protected function DocNotaSoporteDiscrepancyTrait($Document , &$jsonObject, $FechaTransacion, $Anulados  ) {      
 
         $jsonObject['billing_reference']= [
            'number'            => trim($Anulados["prfjo_dcmnto"]).trim($Anulados["nro_dcmnto"] ),
            'uuid'              => $Anulados["uuid"],
            'issue_date'        => Fecha::YMD( Carbon::now()) 
            ] ;

        }


    protected function DocSoporteEnvironmentTrait ( &$jsonObject ) {
        $jsonObject['environment']=[
                'type_environment_id' => '1',                                      // 1 producction,   2 habilitacion o pruebas
        ]; 
    }

    protected function DocSoporteResolutionTrait ( &$jsonObject ) {
         
        $jsonObject['resolution']=[
                'prefix'          => 'SEDS',                                   
                'resolution'      => '18760000001',                            
                'resolution_date' => '2022-01-01',                               
                'technical_key'   => 'fc8eac422eba16e22ffd8c6f94b3f40a6e38162c',   
                'from'            => '984000000',                              
                'to'              => '985000000',                              
                'date_from'       => '2022-01-01',                               
                'date_to'         => '2022-12-31',                               
        ]; 
    }


    protected function DocSoporteWithHoldingTaxTotalsTrait( $Retenciones, &$jsonObject, $jsonKey  ) {
        
        if (  $Retenciones->count() === 0 )  return ;

        $WithHoldingTaxTotals    = [];
        $WithHoldingTaxTotalLine = [];
        foreach ($Retenciones as $Retencion) {
           $WithHoldingTaxTotalLine = [
             'tax_id'         => $Retencion['tax_id'],
             'percent'        => Numbers::jsonFormat ( $Retencion['percent'], 2),
             'tax_amount'     => Numbers::jsonFormat ( $Retencion['tax_amount'], 2),
             'taxable_amount' => Numbers::jsonFormat ( $Retencion['taxable_amount'], 2),  
           ];  
            $WithHoldingTaxTotals[] = $WithHoldingTaxTotalLine ;
        }
        $jsonObject [$jsonKey] = $WithHoldingTaxTotals;
    }

    protected function DocSoporteLegalMonetaryTotalsTrait ( $Totals, &$jsonObject, $key  ) {
        $jsonObject[$key] =[
            'line_extension_amount'  => Numbers::jsonFormat($Totals['line_extension_amount'],2),        // Total Valor Bruto (Antes de tributos)
            'tax_exclusive_amount'   => Numbers::jsonFormat($Totals  ['tax_exclusive_amount'],2),       // Total Valor Base Imponible (Base imponible para el cálculo de los tributos)
            'tax_inclusive_amount'   => Numbers::jsonFormat($Totals  ['tax_inclusive_amount'],2),       // Total de Valor Bruto más tributos
            'payable_amount'         => Numbers::jsonFormat($Totals  ['payable_amount'],2),             // Valor de la Factura
        ];      
    }

    protected function DocSoporteInvoiceLinesTrait ( $Products, &$jsonObject, $jsonKey, $FechaTransacion  ) {
        $Productos = [];          
        foreach ($Products as $Product) {
         $ProductToCreate = [
             'invoiced_quantity'           => Numbers::jsonFormat ( $Product['invoiced_quantity'], 6),
             'vendor_code'                 => $Product['code'],
             'line_extension_amount'       => Numbers::jsonFormat ($Product['line_extension_amount'], 2),
             'invoice_period'              => [
                'start_date'                        =>  Fecha::YMD( $FechaTransacion) ,
                'form_generation_transmission_id'   => '1' ,  
             ],
             'description'                 => $Product['description'],
             'code'                        => $Product['code'],
             'price_amount'                => Numbers::jsonFormat ($Product['price_amount'],2),
             'base_quantity'               => Numbers::jsonFormat ($Product['base_quantity'],2)
           ];  
 
            $Productos[] = $ProductToCreate ;
        }
        $jsonObject [$jsonKey] = $Productos;
    }

 

    protected function traitDocumentSoportReponseSave( $id_fact_elctrnca, $dataResponse) {
        DocSoporteResponse::where('id_fact_elctrnca', $id_fact_elctrnca)->delete();
        $FctrasDataReponse = new DocSoporteResponse;
        $FctrasDataReponse->id_fact_elctrnca                   = $id_fact_elctrnca;
        $FctrasDataReponse->qr_data                            = $dataResponse['qr_data'];
        $FctrasDataReponse->attached_document_base64_bytes     = $dataResponse['attached_document_base64_bytes'];
        $FctrasDataReponse->application_response_base64_bytes  = '' ;
        $FctrasDataReponse->pdf_base64_bytes                   = '' ;
        $FctrasDataReponse->save(); 
    }


}
