<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FctrasElctrncasAdditional extends Model
{
	protected $table = 'fctras_elctrncas_additionals';
	public $timestamps = false;

	protected $casts = [
		'id_fact_elctrnca' => 'int',
		'vr_base' => 'float',
		'pctje_iva' => 'float',
		'vr_iva' => 'float'
	];

	protected $fillable = [
		'id_fact_elctrnca',
		'dpto',
		'frma_pgo',
		'nro_tlfno',
		'vr_letras',
		'vr_base',
		'pctje_iva',
		'vr_iva'
	];

	public function fctras_elctrnca()
	{
		return $this->belongsTo(FctrasElctrnca::class, 'id_fact_elctrnca');
	}

	public function getVrLetrasAttribute ( $value ){
		return trim ( $value );
	}
	
}
