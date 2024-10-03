<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FctrasElctrncasExport extends Model
{
	protected $table = 'fctras_elctrncas_exports';
	public $timestamps = false;

	protected $casts = [
		'id_fact_elctrnca' => 'int',
		'trm_dia' => 'float',
		'trm_factor' => 'float',
	];

	protected $fillable = [
		'idregistro',
		'id_fact_elctrnca',
		'trm_dia',
		'trm_factor',
		'cndcion_pago',
		'total_items',
		'observ_1',
		'observ_2',
		'observ_3',
		'observ_4',
		'observ_5',
		'export_incoterm',
		'export_dscrpcion',
		'export_medio_trnsprte',
		'export_pais_origen',
		'export_peso_neto',
		'export_pais_destino',
		'export_ciudad_destino',
		'export_peso_bruto',
		'valor_letras',
		'trm_text'

	];

	public function fctras_elctrnca()
	{
		return $this->belongsTo(FctrasElctrnca::class, 'id_fact_elctrnca');
	}

	public function getCndcionPagoAttribute ( $value ){
		return trim ( $value );
	}
	public function getObserv1Attribute($value) {
		return trim($value);
	}
	
	public function getObserv2Attribute($value) {
		return trim($value);
	}
	
	public function getObserv3Attribute($value) {
		return trim($value);
	}
	
	public function getObserv4Attribute($value) {
		return trim($value);
	}
	
	public function getObserv5Attribute($value) {
		return trim($value);
	}
	
	public function getExportIncotermAttribute($value) {
		return trim($value);
	}
	
	public function getExportDscrpcionAttribute($value) {
		return trim($value);
	}
	
	public function getExportMedioTrnsprteAttribute($value) {
		return trim($value);
	}
	
	public function getExportPaisOrigenAttribute($value) {
		return trim($value);
	}
	
	public function getExportPesoNetoAttribute($value) {
		return trim($value);
	}
	
	public function getExportPaisDestinoAttribute($value) {
		return trim($value);
	}
	
	public function getExportCiudadDestinoAttribute($value) {
		return trim($value);
	}
	
	public function getExportPesoBrutoAttribute($value) {
		return trim($value);
	}

	public function getValorLetrasAttribute($value) {
		return  strtoupper( trim($value));
	}
	public function getTrmTextAttribute($value) {
		return  strtoupper( trim($value));
	}

	
}
