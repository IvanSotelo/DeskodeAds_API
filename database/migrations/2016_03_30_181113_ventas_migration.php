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
            $table->integer('Cliente_id')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('Cliente_id')->references('IdCliente')->on('clientes');
            $table->integer('Vendedor_id')->unsigned();
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('Vendedor_id')->references('IdVendedor')->on('vendedores');
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
