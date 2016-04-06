<?php
 
use Illuminate\Database\Seeder;
 
// Hace uso del modelo de Cliente.
use App\Cliente;
use App\Usuario;
 
 
// Le indicamos que utilice también Faker.
// Información sobre Faker: https://github.com/fzaninotto/Faker
use Faker\Factory as Faker;
 
class ClienteSeeder extends Seeder {
 
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Creamos una instancia de FakerO
		$faker = Faker::create();
 		$clientes= Usuario::where('Privilegio','Cliente')->get();
		// Creamos un bucle para cubrir 5 Clientes:
		for ($i=0; $i<count($clientes); $i++)
		{
			$id=$clientes[$i]->IdUsuario;
			// Cuando llamamos al método create del Modelo Cliente
			// se está creando una nueva fila en la tabla.
			Cliente::create(
				[
					'Nombre'=>$faker->name(),
					'Telefono'=>$faker->phoneNumber(),
					'Direccion'=>$faker->address(),
					'Email'=>$faker->freeEmail(),
					'RFC'=>$faker->swiftBicNumber (),
					'IdUsuario'=>$id
				]
			);
		}
 
	}
}