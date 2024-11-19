<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TiposDcmnto
 * 
 * @property int $id_tp_dcmnto
 * @property string $nom_tp_dcmnto
 * @property bool $inactivo
 * 
 * @property Collection|Tercero[] $terceros
 *
 * @package App\Models
 */
class TiposDcmnto extends Model
{
	protected $table = 'tipos_dcmntos';
	protected $primaryKey = 'id_tp_dcmnto';
	public $timestamps = false;

	protected $casts = [
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'nom_tp_dcmnto',
		'inactivo'
	];

	public function terceros()
	{
		return $this->hasMany(Tercero::class, 'id_tp_dcmnto');
	}
}
