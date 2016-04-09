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
Route::resource('categorias','CategoriaController');
Route::resource('clientes','ClienteController');
Route::resource('clientes.pagos','ClientePagoController');
Route::resource('clientes.videos','ClienteVideoController');
Route::resource('comentarios','ComentarioController');
Route::resource('pagos','PagoController');
Route::resource('pantallas','PantallaController');
Route::resource('pantallas.videos','PantallaVideoController');
Route::resource('reproducciones','ReproduccionController');
Route::resource('vendedores','VendedorController');
Route::resource('ventas','VentaController');
Route::resource('ventas.videos','VentaVideoController');
Route::resource('videos','VideoController');
Route::resource('videos.comentarios','VideoComentarioController');
Route::resource('videos.reproducciones','VideoReproduccionController');
Route::get('/', function () {
    return view('welcome');
});
