<?php
 
use Illuminate\Database\Seeder;
 
// Hace uso del modelo de Venta.
use App\Venta;
use App\Cliente;
use App\Vendedor;
use App\Video;
 
 
// Le indicamos que utilice también Faker.
// Información sobre Faker: https://github.com/fzaninotto/Faker
use Faker\Factory as Faker;
 
class VentaSeeder extends Seeder {
 
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Creamos una instancia de FakerO
		$faker = Faker::create();

 		$cuantos= Cliente::all()->count();
 		$cuantos1= Vendedor::all()->count();
		// Creamos un bucle para cubrir 5 Ventas:
		for ($i=0; $i<$cuantos2; $i++)
		{
			// Cuando llamamos al método create del Modelo Venta
			// se está creando una nueva fila en la tabla.
			Venta::create(
				[
					'IdCliente'=>$faker->numberBetween(1,$cuantos),
					'IdVendedor'=>$faker->numberBetween(1,$cuantos1),
					'Estatus'=>$faker->randomElement($array = array ('Pendiente','Pagado')),
					'Precio'=>$faker->randomNumber(9),
					'Paquete'=>$faker->randomElement($array = array ('Individual','Doble'))
				]
			);
		}
 
	}
}