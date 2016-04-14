<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Necesita los dos modelos Cliente y Pago
use App\Cliente;
use App\Pago;

// Necesitamos la clase Response para crear la respuesta especial con la cabecera de localización en el método Store()
use Response;

class ClientePagoController extends Controller
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
	public function index($idCliente)
	{
		// Devolverá todos los pagos.
		//return "Mostrando los pagos del Cliente con Id $idCliente";
		$Cliente=Cliente::find($idCliente);
 
		if (!$Cliente)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Cliente con ese código.'])],404);
		}
 
		return response()->json(['status'=>'ok','data'=>$Cliente->pagos()->get()],200);
		//return response()->json(['status'=>'ok','data'=>$Cliente->pagos],200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request,$idCliente)
	{
        /* Necesitaremos el idCliente que lo recibimos en la ruta
		 #Serie (auto incremental)
		Modelo
		Longitud
		Capacidad
		Velocidad
		Alcance */
 
		// Primero comprobaremos si estamos recibiendo todos los campos.
		if ( !$request->input('Pago') || !$request->input('FechaPago') || !$request->input('ProxPago') || !$request->input('Estatus'))
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
		}
 
		// Buscamos el Cliente.
		$Cliente= Cliente::find($idCliente);
 
		// Si no existe el Cliente que le hemos pasado mostramos otro código de error de no encontrado.
		if (!$Cliente)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Cliente con ese código.'])],404);
		}
 
		// Si el Cliente existe entonces lo almacenamos.
		// Insertamos una fila en Pagos con create pasándole todos los datos recibidos.
		$nuevoPago=$Cliente->pagos()->create($request->all());
 
		// Más información sobre respuestas en http://jsonapi.org/format/
		// Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
		$response = Response::make(json_encode(['data'=>$nuevoPago]), 201)->header('Location','http://ads.deskode.local/api/pagos/'.$nuevoPago->IdPago)->header('Content-Type', 'application/json');
		return $response;
	}
 
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($idCliente,$idPago)
	{
		//
		return "Se muestra Pago $idPago del Cliente $idCliente";
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($idCliente,$idPago)
	{
		//
	}
 
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idCliente,$idPago)
	{
		//
	}
}
