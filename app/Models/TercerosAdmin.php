<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 
class TercerosAdmin extends Model
{
	protected $table = 'terceros_admins';
	protected $primaryKey = 'idregistro';
	public $timestamps = false;

	protected $fillable = [
		'email',
		'number_code'
	];
}
