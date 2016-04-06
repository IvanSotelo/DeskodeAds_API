<?php
 
use Illuminate\Database\Seeder;
 
// Hace uso del modelo de Video.
use App\Video;
use App\Cliente;
use App\Categoria;
 
 
// Le indicamos que utilice también Faker.
// Información sobre Faker: https://github.com/fzaninotto/Faker
use Faker\Factory as Faker;
 
class VideoSeeder extends Seeder {
 
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
 		$cuantos1= Categoria::all()->count();
		// Creamos un bucle para cubrir 5 Clientes:
		for ($i=0; $i<20; $i++)
		{
			// Cuando llamamos al método create del Modelo Video
			// se está creando una nueva fila en la tabla.
			Video::create(
				[
					'FechaAlta'=>$faker->date('Y-m-d'),
					'FechaBaja'=>$faker->date('Y-m-d'),
					'URL'=>$faker->image($dir = '/tmp', $width = 640, $height = 480),
					'IdCliente'=>$faker->numberBetween(1,$cuantos),
					'IdCategoria'=>$faker->numberBetween(1,$cuantos1)
				]
			);
		}
 
	}
}