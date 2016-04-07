<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class VentaVideoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idVenta)
	{
		// Devolverá todos los videos.
		return "Mostrando los videos de la Venta con Id $idVenta";
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
