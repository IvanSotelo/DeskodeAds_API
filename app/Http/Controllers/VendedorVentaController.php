<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// Necesita los dos modelos Vendedor y Venta
use App\Vendedor;
use App\Venta;

class VendedorVentaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idVendedor)
	{
		// Devolverá todos las ventas.
		//return "Mostrando las ventas del Vendedor con Id $idVendedor";
		$Vendedor=Vendedor::find($idVendedor);
 
		if (! $Vendedor)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Vendedor con ese código.'])],404);
		}
 
		return response()->json(['status'=>'ok','data'=>$Vendedor->ventas()->get()],200);
		//return response()->json(['status'=>'ok','data'=>$Vendedor->aviones],200);
	}
 
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($idVendedor)
	{
		//
		return "Se muestra formulario para crear una Venta del Vendedor $idVendedor.";
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
	public function show($idVendedor,$idVenta)
	{
		//
		return "Se muestra Venta $idVenta del Vendedor $idVendedor";
	}
 
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($idVendedor,$idVenta)
	{
		//
		return "Se muestra formulario para editar la Venta $idVenta del Vendedor $idVendedor";
	}
 
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($idVendedor,$idVenta)
	{
		//
	}
 
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idVendedor,$idVenta)
	{
		//
	}
}
