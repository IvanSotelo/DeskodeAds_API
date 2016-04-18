<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['prefix' => 'api/v1'], function () {
	Route::resource('categorias','CategoriaController',['except'=>['edit','create'] ]);
	Route::resource('categorias.pantallas','CategoriaPantallaController',['only'=>['index','show'] ]);
	Route::resource('pantallas.categorias','PantallaCategoriaController',['only'=>['index','show'] ]);
	Route::resource('clientes','ClienteController',['except'=>['edit','create'] ]);
	Route::resource('clientes.pagos','ClientePagoController',['except'=>['edit','create','show'] ]);
	Route::resource('clientes.videos','ClienteVideoController',['only'=>['index','show'] ]);
	Route::resource('clientes.compras','ClienteVentaController',['only'=>['index','show'] ]);
	Route::resource('comentarios','ComentarioController',['only'=>['index','show'] ]);
	Route::resource('pagos','PagoController',['only'=>['index','show']]);
	Route::resource('pantallas','PantallaController',['except'=>['edit','create'] ]);
	Route::resource('pantallas.videos','PantallaVideoController',['only'=>['index','show'] ]);
	Route::resource('reproducciones','ReproduccionController',['only'=>['index','show'] ]);
	Route::resource('vendedores','VendedorController',['except'=>['edit','create'] ]);
	Route::resource('vendedores.ventas','VendedorVentaController',['only'=>['index','show'] ]);
	Route::resource('ventas','VentaController',['except'=>['edit','create'] ]);
	Route::resource('ventas.videos','VentaVideoController',['only'=>['index','show'] ]);
	Route::resource('videos','VideoController',['except'=>['edit','create'] ]);
	Route::resource('videos.comentarios','VideoComentarioController',['except'=>['edit','create','show']]);
	Route::resource('videos.reproducciones','VideoReproduccionController',['except'=>['edit','create','show']]);
});
Route::get('/', function () {
    return view('welcome');
});
