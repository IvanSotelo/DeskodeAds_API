<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
   // Nombre de la tabla en MySQL.
	protected $table="ventas";
	protected $primaryKey = 'IdVenta';
 
	// Atributos que se pueden asignar de manera masiva.
	protected $fillable = array('Estatus','Precio','IdVideo','IdCliente','IdVendedor');
 
	// Aquí ponemos los campos que no queremos que se devuelvan en las consultas.
	protected $hidden = ['created_at','updated_at']; 
 
	// Definimos a continuación la relación de esta tabla con otras.
	// Ejemplos de relaciones:
	// 1 usuario tiene 1 teléfono   ->hasOne() Relación 1:1
	// 1 teléfono pertenece a 1 usuario   ->belongsTo() Relación 1:1 inversa a hasOne()
	// 1 post tiene muchos comentarios  -> hasMany() Relación 1:N 
	// 1 comentario pertenece a 1 post ->belongsTo() Relación 1:N inversa a hasMany()
	// 1 usuario puede tener muchos roles  ->belongsToMany()
	//  etc..
 
	// Relación de venta con video:
	public function video()
	{	
		// 1 venta tiene un video
		// $this hace referencia al objeto que tengamos en ese momento de Venta.
		return $this->hasOne('App\Video');
	}

	// Relación de venta con cliente:
	public function cliente()
	{	
		// 1 venta pertenece a un cliente
		// $this hace referencia al objeto que tengamos en ese momento de Venta.
		return $this->belongsTo('App\Cliente');
	}

		// Relación de venta con vendedor:
	public function vendedor()
	{	
		// 1 venta pertenece a un vendedor
		// $this hace referencia al objeto que tengamos en ese momento de Venta.
		return $this->belongsTo('App\Vendedor');
	}
}
