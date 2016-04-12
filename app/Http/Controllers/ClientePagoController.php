<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// Necesita los dos modelos Cliente y Pago
use App\Cliente;
use App\Pago;

class ClientePagoController extends Controller
{
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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($idCliente)
	{
		//
		return "Se muestra formulario para crear un Pago del Cliente $idCliente.";
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
	public function show($idCliente,$idPago)
	{
		//
		return "Se muestra Pago $idPago del Cliente $idCliente";
	}
 
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($idCliente,$idPago)
	{
		//
		return "Se muestra formulario para editar el Pago $idPago del Cliente $idCliente";
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
