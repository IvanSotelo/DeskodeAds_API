<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Necesita los dos modelos Pantalla y Categoria
use App\Pantalla;
use App\Categoria;

// Activamos uso de caché.
use Illuminate\Support\Facades\Cache;

class PantallaCategoriaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idCategoria)
	{
		// Devolverá todos las pantallas.
		//return "Mostrando las pantallas de la categoria con Id $idCategoria";
		$Categoria=Categoria::find($idCategoria);
 
		if (!$Categoria)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Categoria con ese código.'])],404);
		}
		// Activamos la caché de los resultados.
		// Como el closure necesita acceder a la variable $ fabricante tenemos que pasársela con use($fabricante)
		// Para acceder a los modelos no haría falta puesto que son accesibles a nivel global dentro de la clase.
		//  Cache::remember('tabla', $minutes, function()
		$pantallas=Cache::remember('clavePantallas',2, function() use ($Categoria)
		{
			// Caché válida durante 2 minutos.
			return $Categoria->pantallas()->get();
		});
 
		// Respuesta con caché:
		return response()->json(['status'=>'ok','data'=>$pantallas],200);
 
		// Respuesta sin caché:
		//return response()->json(['status'=>'ok','data'=>$Categoria->pantallas()->get()],200);
		//return response()->json(['status'=>'ok','data'=>$Categoria->aviones],200);
	} 
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($idCategoria,$idPantalla)
	{
		//
		return "Se muestra la Pantalla $idPantalla de la Categoria $idCategoria";
	}
}
