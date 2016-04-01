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
            $table->string('Comentario');
            $table->date('Fecha');

            // Añadimos la clave foránea con Fabricante. fabricante_id
            // Acordarse de añadir al array protected $fillable del fichero de modelo "Avion.php" la nueva columna:
            // protected $fillable = array('modelo','longitud','capacidad','velocidad','alcance','fabricante_id');
            $table->integer('IdUsuario')->unsigned();
 
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('IdUsuario')->references('IdUsuario')->on('usuarios');

             $table->integer('IdVideo')->unsigned();
 
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('IdVideo')->references('IdVideo')->on('videos');
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
