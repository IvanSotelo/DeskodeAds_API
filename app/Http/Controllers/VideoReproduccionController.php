<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// Necesita los dos modelos Video y Reproduccion
use App\Video;
use App\Reproduccion;

class VideoReproduccionController extends Controller
{
	// Configuramos en el constructor del controlador la autenticación usando el Middleware auth.basic,
	// pero solamente para los métodos de crear, actualizar y borrar.
	public function __construct()
	{
		$this->middleware('auth.basic',['only'=>['store','update','destroy']]);
	}
 
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idVideo)
	{
		// Devolverá todos las reproducciones.
		//return "Mostrando las reproducciones del Video con Id $idVideo";
		$Video=Video::find($idVideo);
 
		if (! $Video)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Video con ese código.'])],404);
		}
 
		return response()->json(['status'=>'ok','data'=>$Video->reproducciones()->get()],200);
		//return response()->json(['status'=>'ok','data'=>$Video->aviones],200);
	}
 
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($idVideo)
	{
		//
		return "Se muestra formulario para crear una Reproduccion del Video $idVideo.";
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
	public function show($idVideo,$idReproduccion)
	{
		//
		return "Se muestra Reproduccion $idReproduccion del Video $idVideo";
	}
 
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($idVideo,$idReproduccion)
	{
		//
		return "Se muestra formulario para editar la Reproduccion $idReproduccion del Video $idVideo";
	}
 
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($idVideo,$idReproduccion)
	{
		//
	}
 
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idVideo,$idReproduccion)
	{
		//
	}
}
