<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ComentariosMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->increments('IdComentario');
            // Añadimos la clave foránea con Fabricante. fabricante_id
            // Acordarse de añadir al array protected $fillable del fichero de modelo "Avion.php" la nueva columna:
            // protected $fillable = array('modelo','longitud','capacidad','velocidad','alcance','fabricante_id');
            $table->integer('Usuario_id')->unsigned();
 
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('Usuario_id')->references('IdUsuario')->on('usuarios');

            $table->integer('Video_id')->unsigned();
 
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('Video_id')->references('IdVideo')->on('videos');
            $table->string('Comentario');
            $table->date('Fecha');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comentarios');
    }
}
