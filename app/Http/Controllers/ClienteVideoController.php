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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($idCliente)
	{
		//
		return "Se muestra formulario para crear un video del Cliente $idCliente.";
	}
 
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
 
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($idCliente,$idVideo)
	{
		//
		return "Se muestra formulario para editar el video $idVideo del Cliente $idCliente";
	}
 
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($idCliente,$idVideo)
	{
		//
	}
 
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idCliente,$idVideo)
	{
		//
	}
}
