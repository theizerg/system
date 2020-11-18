<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comprobante;

class Moneda extends Model
{	
	protected $table = 'monedas';

	protected $fillable = [
		'nombre','simbolo', 'redondeo'
	];


	public function comprobantes(){
		return $this->hasMany(Comprobante::class)->withTrashed();
	}
}
