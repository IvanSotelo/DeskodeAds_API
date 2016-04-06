<?php
 
use Illuminate\Database\Seeder;
 
// Hace uso del modelo de Vendedor.
use App\Vendedor;
use App\Usuario;
 
 
// Le indicamos que utilice también Faker.
// Información sobre Faker: https://github.com/fzaninotto/Faker
use Faker\Factory as Faker;
 
class VendedorSeeder extends Seeder {
 
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Creamos una instancia de FakerO
		$faker = Faker::create();
 		$vendedores= Usuario::where('Privilegio','Vendedor')->get();
		// Creamos un bucle para cubrir 5 Clientes:
		for ($i=0; $i<count($vendedores); $i++)
		{
			$id=$vendedores[$i]->IdUsuario;
			// Cuando llamamos al método create del Modelo Vendedor
			// se está creando una nueva fila en la tabla.
			Vendedor::create(
				[
					'Nombre'=>$faker->firstName(),
					'Apellido'=>$faker->lastName(),
					'Telefono'=>$faker->phoneNumber(),
					'IdUsuario'=>$id
				]
			);
		}
 
	}
}