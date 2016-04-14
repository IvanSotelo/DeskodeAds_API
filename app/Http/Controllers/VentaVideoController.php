<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// Necesita los dos modelos Video y Venta
use App\Video;
use App\Venta;

class VentaVideoController extends Controller
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
	public function index($idVenta)
	{
		// Devolverá todos los videos.
		//return "Mostrando los videos de la Venta con Id $idVenta";
		$Venta=Venta::find($idVenta);
 
		if (! $Venta)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Venta con ese código.'])],404);
		}
 
		return response()->json(['status'=>'ok','data'=>$Venta->videos()->get()],200);
		//return response()->json(['status'=>'ok','data'=>$Venta->aviones],200);
	}
 
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($idVenta)
	{
		//
		return "Se muestra formulario para crear un Video de la Venta $idVenta.";
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
	public function show($idVenta,$idVideo)
	{
		//
		return "Se muestra Video $idVideo de la Venta $idVenta";
	}
 
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($idVenta,$idVideo)
	{
		//
		return "Se muestra formulario para editar el Video $idVideo de la Venta $idVenta";
	}
 
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($idVenta,$idVideo)
	{
		//
	}
 
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idVenta,$idVideo)
	{
		//
	}
}
