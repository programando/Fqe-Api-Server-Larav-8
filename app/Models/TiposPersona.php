<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TiposPersona
 * 
 * @property int $id_tp_persona
 * @property string $nom_tp_persona
 * @property bool $inactivo
 * 
 * @property Collection|Tercero[] $terceros
 *
 * @package App\Models
 */
class TiposPersona extends Model
{
	protected $table = 'tipos_personas';
	protected $primaryKey = 'id_tp_persona';
	public $timestamps = false;

	protected $casts = [
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'nom_tp_persona',
		'inactivo'
	];

	public function Terceros()
	{
		return $this->hasMany(Tercero::class, 'id_tp_persona');
	}
}
