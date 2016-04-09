<?php
 
use Illuminate\Database\Seeder;
 
// Hace uso del modelo de Reproduccion.
use App\Reproduccion;
use App\Video;
 
 
// Le indicamos que utilice también Faker.
// Información sobre Faker: https://github.com/fzaninotto/Faker
use Faker\Factory as Faker;
 
class ReproduccionSeeder extends Seeder {
 
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
		// Creamos un bucle para cubrir 5 Ventas:
		for ($i=0; $i<20; $i++)
		{
			// Cuando llamamos al método create del Modelo Reproduccion
			// se está creando una nueva fila en la tabla.
			Reproduccion::create(
				[
					'IdVideo'=>$faker->numberBetween(1,$cuantos),
					'Mes'=>$faker->monthName(),
					'Year'=>$faker->year('now'),
					'Reproducciones'=>$faker->randomNumber(9),
					'Vistas'=>$faker->randomNumber(9)
				]
			);
		}
 
	}
}