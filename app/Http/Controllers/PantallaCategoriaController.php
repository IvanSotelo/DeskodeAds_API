<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PantallaCategoriaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idCategoria)
	{
		// Devolverá todos las pantallas.
		return "Mostrando las pantallas de la Categoria con Id $idCategoria";
	}
 
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($idCategoria)
	{
		//
		return "Se muestra formulario para crear una Pantalla de la Categoria $idCategoria.";
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
	public function show($idCategoria,$idPantalla)
	{
		//
		return "Se muestra la Pantalla $idPantalla de la Categoria $idCategoria";
	}
 
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($idCategoria,$idPantalla)
	{
		//
		return "Se muestra formulario para editar la Pantalla $idPantalla de la Categoria $idCategoria";
	}
 
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($idCategoria,$idPantalla)
	{
		//
	}
 
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idCategoria,$idPantalla)
	{
		//
	}
}
