<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PantallaVideoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idPantalla)
	{
		// Devolverá todos los videos.
		return "Mostrando los videos de la Pantalla con Id $idPantalla";
	}
 
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($idPantalla)
	{
		//
		return "Se muestra formulario para crear un Video de la Pantalla $idPantalla.";
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
	public function show($idPantalla,$idVideo)
	{
		//
		return "Se muestra Video $idVideo de la Pantalla $idPantalla";
	}
 
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($idPantalla,$idVideo)
	{
		//
		return "Se muestra formulario para editar el Video $idVideo de la Pantalla $idPantalla";
	}
 
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($idPantalla,$idVideo)
	{
		//
	}
 
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idPantalla,$idVideo)
	{
		//
	}
}
