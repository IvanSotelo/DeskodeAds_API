<?php

use Illuminate\Database\Seeder;

// Hace uso del modelo de Video.
use App\Video;
use App\Pantalla;


// Le indicamos que utilice también Faker.
// Información sobre Faker: https://github.com/fzaninotto/Faker
use Faker\Factory as Faker;

class RelacionVideosPantallasSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Creamos una instancia de FakerO
		$faker = Faker::create();
 		$cuantos= Video::all()->count();
 		$cuantos1= Pantalla::all()->count();
		// Creamos un bucle para cubrir 5 Clientes:
		for ($i=0; $i<20; $i++)
		{
			// Cuando llamamos al método create del Modelo Video

			$Video=Video::find($faker->numberBetween(1,$cuantos));
			$Pantalla=Pantalla::find($faker->numberBetween(1,$cuantos1));
			$Video->pantallas()->attach($Pantalla->IdPantalla);
		}

	}
}
