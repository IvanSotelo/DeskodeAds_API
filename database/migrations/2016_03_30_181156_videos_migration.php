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
            $table->integer('IdCliente')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('IdCliente')->references('IdCliente')->on('clientes');
            $table->integer('IdCategoria')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('IdCategoria')->references('IdCategoria')->on('categorias');
            $table->integer('IdPantalla')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('IdPantalla')->references('IdPantalla')->on('pantallas');   
            $table->integer('IdVenta')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('IdVenta')->references('IdVenta')->on('ventas');           
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
