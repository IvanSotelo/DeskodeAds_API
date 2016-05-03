<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Model::unguard();
		$this->call('CategoriaSeeder');
		$this->call('UsuarioSeeder');
	  $this->call('ClienteSeeder');
	  $this->call('VendedorSeeder');
	  $this->call('PantallaSeeder');
	  $this->call('VentaSeeder');
	  $this->call('VideoSeeder');
	  $this->call('ComentarioSeeder');
	  $this->call('ReproduccionSeeder');
	  $this->call('PagoSeeder');
    // $this->call(UsersTableSeeder::class);
    }
}
