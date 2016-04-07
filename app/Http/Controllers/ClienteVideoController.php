<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

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
		return "Mostrando los videos del Cliente con Id $idCliente";
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
