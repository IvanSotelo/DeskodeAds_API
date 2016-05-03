<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Necesita los dos modelos Video y Comentario
use App\Video;
use App\Comentario;

// Activamos uso de caché.
use Illuminate\Support\Facades\Cache;

// Necesitamos la clase Response para crear la respuesta especial con la cabecera de localización en el método Store()
use Response;

class VideoComentarioController extends Controller
{
	// Configuramos en el constructor del controlador la autenticación usando el Middleware auth.basic,
	// pero solamente para los métodos de crear, actualizar y borrar.
	//public function __construct()
	//{
	//	$this->middleware('auth.basic',['only'=>['store','update','destroy']]);
	//}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idVideo)
	{
		// Devolverá todos los comentarios.
		//return "Mostrando los comentarios del Video con Id $idVideo";
		$Video=Video::find($idVideo);

		if (!$Video)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Video con ese código.'])],404);
		}

 		// Activamos la caché de los resultados.
		// Como el closure necesita acceder a la variable $ fabricante tenemos que pasársela con use($fabricante)
		// Para acceder a los modelos no haría falta puesto que son accesibles a nivel global dentro de la clase.
		//  Cache::remember('tabla', $minutes, function()
		$Comentarios=Cache::remember('claveComentarios',2, function() use ($Video)
		{
			// Caché válida durante 2 minutos.
			return $Video->comentarios()->get();
		});

		// Respuesta con caché:
		return response()->json(['status'=>'ok','data'=>$Comentarios],200);

		// Respuesta sin caché:
		//return response()->json(['status'=>'ok','data'=>$Video->comentarios()->get()],200);
		//return response()->json(['status'=>'ok','data'=>$Video->aviones],200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request,$idVideo)
	{
        /* Necesitaremos el idVideo que lo recibimos en la ruta */

		// Primero comprobaremos si estamos recibiendo todos los campos.
		if ( !$request->input('Video_id') || !$request->input('Usuario_id') || !$request->input('Comentario') || !$request->input('Fecha'))
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
		}

		// Buscamos el Video.
		$Video= Video::find($idVideo);

		// Si no existe el Video que le hemos pasado mostramos otro código de error de no encontrado.
		if (!$Video)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Video con ese código.'])],404);
		}

		// Si el Video existe entonces lo almacenamos.
		// Insertamos una fila en comentarios con create pasándole todos los datos recibidos.
		$nuevoComentario=$Video->comentarios()->create($request->all());

		// Más información sobre respuestas en http://jsonapi.org/format/
		// Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
		$response = Response::make(json_encode(['data'=>$nuevoComentario]), 201)->header('Location','http://ads.deskode.local/api/comentarios/'.$nuevoComentario->IdComentario)->header('Content-Type', 'application/json');
		return $response;
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
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($idVideo,$idComentario)
	{
		// Comprobamos si el Video que nos están pasando existe o no.
		$Video=Video::find($idVideo);

		// Si no existe ese Video devolvemos un error.
		if (!$Video)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Video con ese código.'])],404);
		}

		// El Video existe entonces buscamos el Comentario que queremos editar asociado a ese Video.
		$Comentario = $Video->comentarios()->find($idComentario);

		// Si no existe ese Comentario devolvemos un error.
		if (!$Comentario)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Comentario con ese código asociado al Video.'])],404);
		}


		// Listado de campos recibidos teóricamente.
		$Usuario_id=$request->input('Usuario_id');
		$Comentario1=$request->input('Comentario');
		$Fecha=$request->input('Fecha');

		// Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
		// El método de la petición se sabe a través de $request->method();
		if ($request->method() === 'PATCH')
		{
			// Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
			$bandera = false;

			// Actualización parcial de campos.
			if ($Usuario_id!=null&&$Usuario_id!='')
			{
				$Comentario->Usuario_id = $Usuario_id;
				$bandera=true;
			}

			if ($Comentario1!=null&&$Comentario1!='')
			{
				$Comentario->Comentario = $Comentario1;
				$bandera=true;
			}

			if ($Fecha!=null&&$Fecha!='')
			{
				$Comentario->Fecha = $Fecha;
				$bandera=true;
			}

			if ($bandera)
			{
				// Almacenamos en la base de datos el registro.
				$Comentario->save();
				return response()->json(['status'=>'ok','data'=>$Comentario], 200);
			}
			else
			{
				// Se devuelve un array errors con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
				// Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del Comentario.'])],304);
			}

		}

		// Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
		if (!$Usuario_id || !$Comentario1 || !$Fecha)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);
		}

		$Comentario->Usuario_id = $Usuario_id;
		$Comentario->Comentario = $Comentario1;
		$Comentario->Fecha = $Fecha;

		// Almacenamos en la base de datos el registro.
		$Comentario->save();

		return response()->json(['status'=>'ok','data'=>$Comentario], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idVideo,$idComentario)
	{
		// Comprobamos si el Video que nos están pasando existe o no.
		$Video=Video::find($idVideo);

		// Si no existe ese Video devolvemos un error.
		if (!$Video)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Video con ese código.'])],404);
		}

		// El Video existe entonces buscamos el Comentario que queremos borrar asociado a ese Video.
		$Comentario = $Video->comentarios()->find($idComentario);

		// Si no existe ese Comentario devolvemos un error.
		if (!$Comentario)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Comentario con ese código asociado a ese Video.'])],404);
		}

		// Procedemos por lo tanto a eliminar el Comentario.
		$Comentario->delete();

		// Se usa el código 204 No Content – [Sin Contenido] Respuesta a una petición exitosa que no devuelve un body (como una petición DELETE)
		// Este código 204 no devuelve body así que si queremos que se vea el mensaje tendríamos que usar un código de respuesta HTTP 200.
		return response()->json(['code'=>204,'message'=>'Se ha eliminado el Comentario correctamente.'],204);
	}
}
