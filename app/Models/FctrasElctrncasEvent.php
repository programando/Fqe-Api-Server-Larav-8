<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

 
class FctrasElctrncasEvent extends Model
{
	protected $table = 'fctras_elctrncas_events';
	public $timestamps = false;

 

	protected $dates = [
		'event_expedition_date',
		'fcha_rgstro',
 
	];

	protected $fillable = [
		'fcha_rgstro',
		'event_code',
		'event_expedition_date',
		'event_status_message',
		'uuid_document',
		'uud_response'
	];
 
 
 

	public static function maxId(   ) {
		return DB::table('fctras_elctrncas_events')->max('id')+1;
	}


}
