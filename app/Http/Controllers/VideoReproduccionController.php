<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class VideoReproduccionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idVideo)
	{
		// Devolverá todos las reproducciones.
		return "Mostrando las reproducciones del Video con Id $idVideo";
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
