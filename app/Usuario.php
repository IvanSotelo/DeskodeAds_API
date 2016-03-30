<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    //// Nombre de la tabla en MySQL.
	protected $table='usuarios';
 
	// Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
	// Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
	protected $primaryKey = 'IdUsuario';
 
	// Atributos que se pueden asignar de manera masiva.
	protected $fillable = array('Contrasena','Privilegio','Foto');
 
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
 
 
	// Relación de usuario con clientes:
	public function cliente()
	{
		// 1 usuario pertenece a un cliente.
		// $this hace referencia al objeto que tengamos en ese momento de Usuario.
		return $this->belongsTo('App\Cliente');
	}

		// Relación de usuario con vendedores:
	public function vendedor()
	{
		// 1 usuario pertenece a un vendedor.
		// $this hace referencia al objeto que tengamos en ese momento de Usuario.
		return $this->belongsTo('App\Vendedor');
	}
}
}
