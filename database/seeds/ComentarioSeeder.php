<?php
 
use Illuminate\Database\Seeder;
 
// Hace uso del modelo de Comentario.
use App\Comentario;
use App\Usuario;
use App\Video;
 
 
// Le indicamos que utilice también Faker.
// Información sobre Faker: https://github.com/fzaninotto/Faker
use Faker\Factory as Faker;
 
class ComentarioSeeder extends Seeder {
 
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Creamos una instancia de FakerO
		$faker = Faker::create();

 		$cuantos= Usuario::all()->count();
 		$cuantos2= Video::all()->count();
		// Creamos un bucle para cubrir 5 Ventas:
		for ($i=0; $i<19; $i++)
		{
			// Cuando llamamos al método create del Modelo Comentario
			// se está creando una nueva fila en la tabla.
			Comentario::create(
				[
					'IdUsuario'=>$faker->numberBetween(1,$cuantos),
					'IdVideo'=>$faker->numberBetween(1,$cuantos2),
					'Comentario'=>$faker->text(200),
					'Fecha'=>$faker->date('Y-m-d')
				]
			);
		}
 
	}
}