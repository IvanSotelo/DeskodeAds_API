<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReproduccionesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reproducciones', function (Blueprint $table) {

            $table->increments('IdReproduccion');
            $table->string('Mes');
            $table->integer('Year');
            $table->integer('Reproducciones');
            $table->integer('Vistas');

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
        Schema::drop('reproducciones');
    }
}
