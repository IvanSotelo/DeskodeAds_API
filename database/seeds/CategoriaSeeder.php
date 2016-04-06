<?php
 
use Illuminate\Database\Seeder;
 
// Hace uso del modelo de Categoria.
use App\Categoria;
 
 
// Le indicamos que utilice también Faker.
// Información sobre Faker: https://github.com/fzaninotto/Faker
use Faker\Factory as Faker;
 
class CategoriaSeeder extends Seeder {
 
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Creamos una instancia de Faker
		$faker = Faker::create();
 
		// Creamos un bucle para cubrir 5 Categorias:
		for ($i=0; $i<19; $i++)
		{
			// Cuando llamamos al método create del Modelo Categoria
			// se está creando una nueva fila en la tabla.
			Categoria::create(
				[
					'Categoria'=>$faker->word()
				]
			);
		}
 
	}
}