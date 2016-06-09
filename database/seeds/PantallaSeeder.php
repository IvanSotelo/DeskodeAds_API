<?php

use Illuminate\Database\Seeder;

// Hace uso del modelo de Pantalla.
use App\Pantalla;
use App\Categoria;


// Le indicamos que utilice también Faker.
// Información sobre Faker: https://github.com/fzaninotto/Faker
use Faker\Factory as Faker;

class PantallaSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Creamos una instancia de FakerO
		$faker = Faker::create();

 		$cuantos= Categoria::all()->count();

		// Creamos un bucle para cubrir 5 Ventas:
		for ($i=0; $i<20; $i++)
		{
			// Cuando llamamos al método create del Modelo Pantalla
			// se está creando una nueva fila en la tabla.
			Pantalla::create(
				[
					'Categoria_id'=>$faker->numberBetween(1,$cuantos),
					'Ubicacion'=>$faker->company(),
          'Red_id'=>$faker->numberBetween(1,$cuantos),
					'Lat'=>$faker->latitude(-90,90),
					'Lng'=>$faker->longitude(-180,180)
				]
			);
		}

	}
}
