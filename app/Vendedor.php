<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
   // Nombre de la tabla en MySQL.
	protected $table="vendedores";
	protected $primaryKey = 'IdVendedor';
 
	// Atributos que se pueden asignar de manera masiva.
	protected $fillable = array('Nombre','Apellido','Telefono','IdUsuario');
 
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
 
	// Relación de Vendedor con usuarios:
	public function usuario()
	{	
		// 1 vendedor pertenece a un usuario
		// $this hace referencia al objeto que tengamos en ese momento de Vendedor.
		return $this->belongsTo('App\Usuario');
	}
	
	// Relación de Vendedor con ventas:
	public function ventas()
	{	
		// 1 vendedor tiene muchas ventas
		// $this hace referencia al objeto que tengamos en ese momento de Vendedor.
		return $this->hasMany('App\Venta');
	}
}
