<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class VideoComentarioController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idVideo)
	{
		// Devolverá todos los comentarios.
		return "Mostrando los comentarios del Video con Id $idVideo";
	}
 
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($idVideo)
	{
		//
		return "Se muestra formulario para crear un comentario del Video $idVideo.";
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
	public function show($idVideo,$idComentario)
	{
		//
		return "Se muestra comentario $idComentario del Video $idVideo";
	}
 
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($idVideo,$idComentario)
	{
		//
		return "Se muestra formulario para editar el comentario $idComentario del Video $idVideo";
	}
 
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($idVideo,$idComentario)
	{
		//
	}
 
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idVideo,$idComentario)
	{
		//
	}
}
