<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VentasMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('IdVenta');
            $table->integer('IdCliente')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('IdCliente')->references('IdCliente')->on('clientes');
            $table->integer('IdVendedor')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('IdVendedor')->references('IdVendedor')->on('vendedores');
            $table->string('Estatus')->default('Pendiente');
            $table->integer('Precio');
            $table->string('Paquete');

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
        Schema::drop('ventas');
    }
}
