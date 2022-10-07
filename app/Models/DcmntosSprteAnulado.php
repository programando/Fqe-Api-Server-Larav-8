<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DcmntosSprteAnulado
 * 
 * @property int $idregistro
 * @property int $id_fact_elctrnca
 * @property string $prfjo_dcmnto
 * @property int $nro_dcmnto
 * @property string $uuid
 * 
 * @property FctrasElctrnca $fctras_elctrnca
 *
 * @package App\Models
 */
class DcmntosSprteAnulado extends Model
{
	protected $table = 'dcmntos_sprte_anulados';
	protected $primaryKey = 'idregistro';
	public $timestamps = false;

	protected $casts = [
		'id_fact_elctrnca' => 'int',
		'nro_dcmnto' => 'int'
	];

	protected $fillable = [
		'id_fact_elctrnca',
		'prfjo_dcmnto',
		'nro_dcmnto',
		'uuid'
	];

	public function fctras_elctrnca()
	{
		return $this->belongsTo(FctrasElctrnca::class, 'id_fact_elctrnca');
	}
}
