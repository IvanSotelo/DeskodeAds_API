<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VideosMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('IdVideo');
            $table->integer('Cliente_id')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('Cliente_id')->references('IdCliente')->on('clientes');
            $table->integer('Categoria_id')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('Categoria_id')->references('IdCategoria')->on('categorias');
            $table->integer('Pantalla_id')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('Pantalla_id')->references('IdPantalla')->on('pantallas');   
            $table->integer('Venta_id')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('Venta_id')->references('IdVenta')->on('ventas');           
            $table->date('FechaAlta');
            $table->date('FechaBaja')->nullable();
            $table->string('URL');

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
        Schema::drop('videos');
    }
}
