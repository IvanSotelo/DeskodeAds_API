<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelacionVideosPantallasMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relacion_videos_pantallas', function (Blueprint $table) {
            $table->increments('Id');
            $table->integer('Pantalla_id')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('Pantalla_id')->references('IdPantalla')->on('pantallas');
            $table->integer('Video_id')->unsigned();
            $table->foreign('Video_id')->references('IdVideo')->on('videos');
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
        Schema::drop('relacion_videos_pantallas');
    }
}
