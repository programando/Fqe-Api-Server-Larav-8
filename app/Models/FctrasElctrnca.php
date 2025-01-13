<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
//use App\Events\NewInvoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use DB;
class FctrasElctrnca extends Model
{
	protected $primaryKey   = 'id_fact_elctrnca';
	protected $table        = 'fctras_elctrncas';
	public    $allowedSorts = ['fcha_dcmnto'];
	public    $timestamps   = false;
	public    $type         = 'facturas-electronicas';

	protected $casts = [
		'number'            => 'int',
		'sync'              => 'bool',
		'send'              => 'bool',
		'type_operation_id' => 'int',
		'type_document_id'  => 'int',
		'resolution_id'     => 'int',
		'type_currency_id'  => 'int',
		'rspnse_dian'       => 'bool',
		'rspnse_is_valid'   => 'bool'
	];

	protected $dates = [
		'due_date',
		'rspnse_issue_date',
		'fcha_dcmnto'
	];

	protected $fillable = [
		'number',
		'sync',
		'send',
		'notes',
		'type_operation_id',
		'type_document_id',
		'resolution_id',
		'fcha_dcmnto',
		'due_date',
		'type_currency_id',
		'order_reference',
		'receipt_document_reference',
		'rspnse_dian',
		'is_valid',
		'document_number',
		'uuid',
		'issue_date',
		'zip_key',
		'status_code',
		'status_description',
		'status_message',
		'xml_file_name',
		'zip_name',
		'cstmer_rspnse',
		'cstmer_rspnse_date'
	];

		public function fields(){
			return [
					'id'					  => $this->id_fact_elctrnca,
					'prefijo'			  => $this->prfjo_dcmnto,
					'number'        => $this->number,
					'fcha_dcmnto'   => $this->fcha_dcmnto,
					'diffForHumans' => $this->fcha_dcmnto->diffForHumans(),
					'fecha-factura' => $this->fcha_dcmnto->format('d-M-Y'),
					'rspnse_dian'   => $this->is_valid,
			];
		}

		public function customer() {
			return $this->hasOne(FctrasElctrncasCustomer::class, 'id_fact_elctrnca');
			
		}

		public function total() {
			return $this->hasOne(FctrasElctrncasLegalMonetaryTotal::class, 'id_fact_elctrnca');
		}
		public function products() {
			return $this->hasMany(FctrasElctrncasInvoiceLine::class, 'id_fact_elctrnca');
		}
		public function emails() {
			return $this->hasMany(FctrasElctrncasEmailSend::class, 'id_fact_elctrnca');
		}
		public function noteBillingReference() {
			return $this->hasOne(FctrasElctrncasNotesBillingReference::class, 'id_fact_elctrnca');
		}
		public function noteDiscrepancy() {
			return $this->hasOne(FctrasElctrncasNotesDiscrepancyResponse::class, 'id_fact_elctrnca');
		}
		public function additionals() {
			return $this->hasOne(FctrasElctrncasAdditional::class, 'id_fact_elctrnca');
		}
		public function serviceResponse() {
			return $this->hasOne(FctrasElctrncasDataResponse::class, 'id_fact_elctrnca');
		}

		public function docsSoporteRetenciones() {
			return $this->hasMany(DcmntosSprteWithholdingTaxTotal::class, 'id_fact_elctrnca');
		}
 
		public function docsSoporteResponse() {
			return $this->hasMany(FctrasElctrncasSoportDocumentResponse::class, 'id_fact_elctrnca');
		}

		public function dcmntos_sprte_anulados() {
			return $this->hasOne(DcmntosSprteAnulado::class, 'id_fact_elctrnca');
		}


		public function exports() {
			return $this->hasOne(FctrasElctrncasExport::class, 'id_fact_elctrnca');
		}

		// SCOPES
		//=========
			public function scopeInvoicesToSend ( $query ){
				return $query->where('rspnse_dian', '0')->whereBetween('type_document_id', [1, 2]);
			}

			public function scopeCreditNotesToSend ( $query ){
				return $query->Where('rspnse_dian','0')->whereIn('type_document_id', array('5','6'));	// Notas Crédito/Débito
			}
		
			public function scopeInvoicesSearchDataByUUID ($query, $uuid ){
				return $query->Where('uuid', "=","$uuid")->get(); // Facturas
			}

			public function scopeDocumentosSoporteToSend ( $query ){
				return $query->Where('rspnse_dian','0')->where('type_document_id',  array('12'))->get(); // Documentos soporte
			}

			public function scopeDocumentosSoporteNotasToSend ( $query ){
				return $query->Where('rspnse_dian','0')->where('type_document_id',  array('13'))->get(); // Documentos soporte - notas crédito
			}

			public function scopeInvoicesPendientesAceptacionExpresa ( $query ){
				return $query->with('customer')
							->Where('dcment_acptcion','0')
							->where('type_document_id', '1')
							->whereNotNull('uuid')
							->get(['id_fact_elctrnca','uuid', 'prfjo_dcmnto','nro_dcmnto','fcha_dcmnto','fcha_acptcion_exprsa']);  
			}

			public function scopeInvoicesGetStatusEventos ( $query ){
				return $query->with('customer')
							->Where('dcment_acptcion','0')
							->Where('id_fact_elctrnca','>', '5645')
							->where('type_document_id', '1')
							->whereNotNull('uuid')
							->get(['id_fact_elctrnca','uuid', 'prfjo_dcmnto','nro_dcmnto','fcha_dcmnto','fcha_acptcion_exprsa','response_code_030','response_code_031','response_code_032','response_code_033']); // Facturas ->take(10)->
			}

			public function scopeInvoicesUltimas100Generadas($query)
			{
				

				 $numbers = [];
				
				// // Obtener los últimos 15 registros
				$ultimosRegistros = $query->with('customer')
										  ->where('type_document_id', '1')
										  ->whereNotNull('uuid')
										  ->orderBy('id_fact_elctrnca', 'DESC')
										  ->take(100)
										  ->get();
				
				// // Obtener los documentos adicionales que no estén ya en los últimos registros
				$documentosAdicionales = $query->with('customer')
											   ->where('type_document_id', '1')
											   ->whereIn('number', $numbers)
											   ->get();
				
				// // Combinar y devolver
				 
				return $ultimosRegistros->merge($documentosAdicionales);
			}
			

		// ACCESORS
		//=========
			public function getDocumentNumberAttribute( $value ){
				return trim($value);
			}
			

			public function getPrfjoDcmntoAttribute( $value ){
				return trim($value);
			}
			public function getUuidAttribute( $value ){
				return trim($value);
			}



	}
