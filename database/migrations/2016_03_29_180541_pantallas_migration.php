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
            $table->integer('Categoria_id')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('Categoria_id')->references('IdCategoria')->on('categorias');
            $table->string('Ubicacion');
            $table->integer('Red_id');
            $table->decimal('Lat',5,6);
            $table->decimal('Lng',5,6);

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
