<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    // Nombre de la tabla en MySQL.
	protected $table="comentarios";
	protected $primaryKey = 'IdComentario';
 
	// Atributos que se pueden asignar de manera masiva.
	protected $fillable = array('Video_id','Usuario_id','Comentario','Fecha');
 
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
 
	// Relación de Comentarios con videos:
	public function video()
	{	
		// 1 comentario pertenece a un video
		// $this hace referencia al objeto que tengamos en ese momento de Comentario.
		return $this->belongsTo('App\Video');
	}

	// Relación de Comentarios con usuarios:
	public function usuario()
	{	
		// 1 comentario pertenece a un usuario
		// $this hace referencia al objeto que tengamos en ese momento de Comentario.
		return $this->belongsTo('App\Usuario');
	}
}
