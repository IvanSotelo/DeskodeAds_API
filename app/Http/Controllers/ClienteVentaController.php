<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ClienteVentaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idCliente)
	{
		// Devolverá todos las ventas.
		return "Mostrando las ventas del Cliente con Id $idCliente";
	}
 
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($idCliente)
	{
		//
		return "Se muestra formulario para crear una Venta del Cliente $idCliente.";
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
	public function show($idCliente,$idVenta)
	{
		//
		return "Se muestra Venta $idVenta del Vendedor $idCliente";
	}
 
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($idCliente,$idVenta)
	{
		//
		return "Se muestra formulario para editar la Venta $idVenta del Cliente $idCliente";
	}
 
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($idCliente,$idVenta)
	{
		//
	}
 
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idCliente,$idVenta)
	{
		//
	}
}
