<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PantallasMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pantallas', function (Blueprint $table) {
            $table->increments('IdPantalla');
            $table->integer('IdVideo')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('IdVideo')->references('IdVideo')->on('videos');
            $table->integer('IdCategoria')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('IdCategoria')->references('IdCategoria')->on('categorias');

            $table->string('Ubicacion');
            $table->integer('Lat');
            $table->integer('Lng');

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
        Schema::drop('pantallas');
    }
}
