<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    // Nombre de la tabla en MySQL.
	protected $table="clientes";
	protected $primaryKey = 'IdCliente';
 
	// Atributos que se pueden asignar de manera masiva.
	protected $fillable = array('Nombre','Telefono','Direccion','EMail','RFC','IdUsuario');
 
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
 
	// Relación de Cliente con Pagos:
	public function pagos()
	{	
		// 1 cliente tiene muchos pagos
		// $this hace referencia al objeto que tengamos en ese momento de Cliente.
		return $this->hasMany('App\Pago');
	}

	// Relación de Cliente con videos:
	public function videos()
	{	
		// 1 cliente tiene muchos videos
		// $this hace referencia al objeto que tengamos en ese momento de Cliente.
		return $this->hasMany('App\Video');
	}

	// Relación de Cliente con usuarios:
	public function usuario()
	{	
		// 1 cliente pertenece a un usuario
		// $this hace referencia al objeto que tengamos en ese momento de Cliente.
		return $this->belongsTo('App\Usuario');
	}

	// Relación de Cliente con ventas:
	public function ventas()
	{	
		// 1 cliente pertenece a mucha ventas
		// $this hace referencia al objeto que tengamos en ese momento de Cliente.
		return $this->hasMany('App\Venta');
	}
}
