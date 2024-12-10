<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TercerosAdmin
 * 
 * @property int $idregistro
 * @property string $email
 * @property string $number_code
 *
 * @package App\Models
 */
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
