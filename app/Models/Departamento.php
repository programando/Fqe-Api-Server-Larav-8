<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
	protected $table = 'departamentos';
	protected $primaryKey = 'id_dpto';
	public $timestamps = false;

	protected $casts = [
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'cod_dane',
		'nom_dpto',
		'inactivo'
	];

	public function municipios()
	{
		return $this->hasMany(Municipio::class, 'id_dpto');
	}
}
