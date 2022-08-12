<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

 
class FctrasElctrncasPrvdre extends Model
{
	protected $table = 'fctras_elctrncas_prvdres';
	protected $primaryKey = 'idregistro';
	public $timestamps = false;

	protected $casts = [
		'total' => 'float'
	];

	protected $dates = [
		'fecha'
	];

	protected $fillable = [
		'prefijo',
		'folio',
		'cufe',
		'fecha',
		'emisor',
		'total',
		'acuse_030',
		'rechazo_031',
		'recibo_032',
		'aceptacion_033',
	];

	
}
