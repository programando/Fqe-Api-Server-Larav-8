<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 use DB;
use Strings;

class Tercero extends Model
{
	protected $table = 'terceros';
	protected $primaryKey = 'idtercero';
	public $timestamps = false;

	protected $casts = [
		'id_tp_dcmnto' => 'int',
		'id_tp_persona' => 'int',
		'id_mcipio' => 'int',
		'es_cliente' => 'bool',
		'es_proveedor' => 'bool'
	];

	protected $fillable = [
		'id_tp_dcmnto',
		'id_tp_persona',
		'id_mcipio',
		'nro_dcmnto',
		'dv',
		'p_nombre',
		's_nombre',
		'p_apellido',
		's_apellido',
		'razon_social',
		'nro_telefono',
		'direccion',
		'complemento',
		'es_cliente',
		'es_proveedor',
		'inactivo',
		'email'
	];

   protected $attributes = [
        'p_nombre' => '',
        's_nombre' => '',
				'p_apellido' => '',
				's_apellido' => '',
				'razon_social'=> '',
				'complemento' => '', 
				'nro_telefono' => '', 
				'email' => '', 
				'inactivo' => 0, 
				'es_cliente' => 0, 
				'es_proveedor' =>0, 
				'dv' => '', 
    ];


protected $appends  = ['nom_tercero'];

	public function getnomTerceroAttribute() {  
			$NomTercero = '';
			if ( $this->attributes['id_tp_dcmnto'] != 3 ) {
				$NomTercero .=  Strings::UpperTrim( $this->attributes['p_nombre']) . ' ';
				$NomTercero .=  Strings::UpperTrim( $this->attributes['s_nombre']) . ' ';
				$NomTercero .=  Strings::UpperTrim( $this->attributes['p_apellido']) . ' ';
				$NomTercero .=  Strings::UpperTrim( $this->attributes['s_apellido']) . ' ';
			}else {
      	$NomTercero .=  Strings::UpperTrim( $this->attributes['razon_social']) . ' ';
			}
      return  trim($NomTercero);
  }

//-------------//
// MUTATORS //
//-------------//
	public function setpNombreAttribute($value)			{ $this->attributes['p_nombre'] 		= Strings::UpperTrim( $value); 		}
	public function setsNombreAttribute($value)			{ $this->attributes['s_nombre'] 		= Strings::UpperTrim( $value); 		}
	public function setpApellidoAttribute($value)		{ $this->attributes['p_apellido'] 	= Strings::UpperTrim( $value); 		}
	public function setsApellidoAttribute($value)		{ $this->attributes['s_apellido'] 	= Strings::UpperTrim( $value); 		}
	public function setrazonSocialAttribute($value)	{ $this->attributes['razon_social'] = Strings::UpperTrim( $value); 		}
	public function setdireccionAttribute($value)		{ $this->attributes['direccion'] 		= Strings::UpperTrim( $value); 		}
	public function setcomplementoAttribute($value)	{	$this->attributes['complemento'] 		= Strings::UpperTrim( $value); 		}
	public function setnroTelefonoAttribute($value)	{	$this->attributes['nro_telefono'] = Strings::UpperTrim( $value); 		}
 

	public function TiposDocumento()
	{
		return $this->belongsTo(TiposDcmnto::class, 'id_tp_dcmnto');
	}

	public function Municipios()
	{
		return $this->belongsTo(Municipio::class, 'id_mcipio');
	}

	public function TiposPersonas()
	{
		return $this->belongsTo(TiposPersona::class, 'id_tp_persona');
	}
}
