<?php
 
use Illuminate\Database\Seeder;
 
// Hace uso del modelo de Usuario.
use App\Usuario;
 
 
// Le indicamos que utilice también Faker.
// Información sobre Faker: https://github.com/fzaninotto/Faker
use Faker\Factory as Faker;
 
class UsuarioSeeder extends Seeder {
 
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Creamos una instancia de Faker
		$faker = Faker::create();
 
		// Creamos un bucle para cubrir 5 Usuarios:
		for ($i=0; $i<4; $i++)
		{
			// Cuando llamamos al método create del Modelo Usuario
			// se está creando una nueva fila en la tabla.
			Usuario::create(
				[
					'Usuario'=>$faker->userName(),
					'Contrasena'=>$faker->password(),
					'Privilegio'=>$faker->randomElement($array = array ('Cliente','Vendedor')),
					'Foto'=>$faker->image($dir = '/tmp', $width = 640, $height = 480)
				]
			);
		}
 
	}
}