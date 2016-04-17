<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// Necesita los dos modelos Cliente y Video
use App\Cliente;
use App\Video;
class ClienteVideoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idCliente)
	{
		// Devolverá todos los videos.
		//return "Mostrando los videos del fabricante con Id $idCliente";
		$Cliente=Cliente::find($idCliente);
 
		if (! $Cliente)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Cliente con ese código.'])],404);
		}
 
		return response()->json(['status'=>'ok','data'=>$Cliente->videos()->get()],200);
		//return response()->json(['status'=>'ok','data'=>$Cliente->aviones],200);
	}
 
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($idCliente,$idVideo)
	{
		//
		return "Se muestra video $idVideo del Cliente $idCliente";
	}
}
