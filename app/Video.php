<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
   // Nombre de la tabla en MySQL.
	protected $table="videos";
	protected $primaryKey = 'IdVideo';
 
	// Atributos que se pueden asignar de manera masiva.
	protected $fillable = array('Cliente_id','Categoria_id','Pantalla_id','Venta_id','FechaAlta','FechaBaja','URL');
 
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
 
	// Relación de video con cliente:
	public function cliente()
	{	
		// 1 video pertenece a un cliente
		// $this hace referencia al objeto que tengamos en ese momento de Video.
		return $this->belongsTo('App\Cliente');
	}

		// Relación de video con categoria:
	public function categoria()
	{	
		// 1 video tiene una categoria
		// $this hace referencia al objeto que tengamos en ese momento de Video.
		return $this->hasOne('App\Categoria');
	}

	// Relación de video con reproducciones:
	public function reproducciones()
	{	
		// 1 video tiene muchas reproducciones
		// $this hace referencia al objeto que tengamos en ese momento de Video.
		return $this->hasMany('App\Reproduccion');
	}

	// Relación de video con pantallas:
	public function pantallas()
	{	
		// 1 video puede estar en muchas pantallas
		// $this hace referencia al objeto que tengamos en ese momento de Video.
		return $this->belongsToMany('App\Pantalla');
	}

	// Relación de video con comentarios:
	public function comentarios()
	{	
		// 1 video tiene muchos comentarios
		// $this hace referencia al objeto que tengamos en ese momento de Video.
		return $this->hasMany('App\Comentario');
	}

	// Relación de video con venta:
	public function venta()
	{	
		// 1 video pertenece a una venta
		// $this hace referencia al objeto que tengamos en ese momento de Video.
		return $this->belongsTo('App\Venta');
	}
}
