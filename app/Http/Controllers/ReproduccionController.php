<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// Necesitaremos el modelo Reproduccion para ciertas tareas.
use App\Reproduccion;

class ReproduccionController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return response()->json(['status'=>'ok','data'=>Reproduccion::all()], 200);
	}
 
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//return "Se muestra CaReproduccion con id: $id";
		$Reproduccion=Reproduccion::find($id);
 
		// Si no existe ese Reproduccion devolvemos un error.
		if (!$Reproduccion)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Reproduccion con ese código.'])],404);
		}
 
		return response()->json(['status'=>'ok','data'=>$Reproduccion],200);
	}
}
