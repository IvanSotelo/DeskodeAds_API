<?php
 
use Illuminate\Database\Seeder;
 
// Hace uso del modelo de Pago.
use App\Pago;
use App\Cliente;
 
 
// Le indicamos que utilice también Faker.
// Información sobre Faker: https://github.com/fzaninotto/Faker
use Faker\Factory as Faker;
 
class PagoSeeder extends Seeder {
 
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
		// Creamos un bucle para cubrir 5 Ventas:
		for ($i=0; $i<20; $i++)
		{
			// Cuando llamamos al método create del Modelo Pago
			// se está creando una nueva fila en la tabla.
			Pago::create(
				[
					'Pago'=>$faker->randomNumber(9),
					'FechaPago'=>$faker->date('Y-m-d'),
					'ProxPago'=>$faker->date('Y-m-d'),
					'IdCliente'=>$faker->numberBetween(1,$cuantos)
				]
			);
		}
 
	}
}