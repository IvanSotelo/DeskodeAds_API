<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// Necesita los dos modelos Pantalla y Video
use App\Pantalla;
use App\Video;

class PantallaVideoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idPantalla)
	{
		// Devolverá todos los videos.
		//return "Mostrando los videos de la Pantalla con Id $idPantalla";
		$Pantalla=Pantalla::find($idPantalla);
 
		if (!$Pantalla)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Pantalla con ese código.'])],404);
		}
 
		return response()->json(['status'=>'ok','data'=>$Pantalla->videos()->get()],200);
		//return response()->json(['status'=>'ok','data'=>$Pantalla->videos],200);
	}
 
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($idPantalla,$idVideo)
	{
		//
		return "Se muestra Video $idVideo de la Pantalla $idPantalla";
	}
}
