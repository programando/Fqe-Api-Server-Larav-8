<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
	protected $table = 'municipios';
	protected $primaryKey = 'id_mcipio';
	public $timestamps = false;

	protected $casts = [
		'id_dpto' => 'int',
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'id_dpto',
		'cod_dane',
		'nom_mcipio',
		'inactivo'
	];

	public function Departamentos()
	{
		return $this->belongsTo(Departamento::class, 'id_dpto');
	}

	public function Terceros()
	{
		return $this->hasMany(Tercero::class, 'id_mcipio');
	}
}
