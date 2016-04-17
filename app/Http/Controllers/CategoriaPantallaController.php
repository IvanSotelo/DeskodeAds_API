<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Necesita los dos modelos Pantalla y Categoria
use App\Pantalla;
use App\Categoria;

class CategoriaPantallaController extends Controller
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
		return response()->json(['status'=>'ok','data'=>$Categoria->pantallas()->get()],200);
		//return response()->json(['status'=>'ok','data'=>$Categoria->aviones],200);
	}
}
