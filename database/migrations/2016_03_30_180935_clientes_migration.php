<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClientesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('IdCliente');
            // Añadimos la clave foránea con Fabricante. fabricante_id
            // Acordarse de añadir al array protected $fillable del fichero de modelo "Avion.php" la nueva columna:
            // protected $fillable = array('modelo','longitud','capacidad','velocidad','alcance','fabricante_id');
            $table->integer('IdUsuario')->unsigned();
 
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('IdUsuario')->references('IdUsuario')->on('usuarios');
            $table->string('Nombre');
            $table->string('Telefono');
            $table->string('Direccion');
            $table->string('EMail');
            $table->string('RFC');


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
        Schema::drop('clientes');
    }
}
