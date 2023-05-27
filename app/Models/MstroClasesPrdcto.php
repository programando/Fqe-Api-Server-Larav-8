<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MstroClasesPrdcto
 * 
 * @property int $id_clse_prdcto
 * @property string $nom_clse_prdcto
 * @property bool $inactivo
 *
 * @package App\Models
 */
class MstroClasesPrdcto extends Model
{
	protected $table = 'mstro_clases_prdcto';
	protected $primaryKey = 'id_clse_prdcto';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_clse_prdcto' => 'int',
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'nom_clse_prdcto',
		'inactivo'
	];


 			public function getNomClsePrdctoAttribute ( $value ){
				return trim($value);
			}

}
