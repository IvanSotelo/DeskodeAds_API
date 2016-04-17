<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Necesita los dos modelos Video y Reproduccion
use App\Video;
use App\Reproduccion;

// Necesitamos la clase Response para crear la respuesta especial con la cabecera de localización en el método Store()
use Response;

class VideoReproduccionController extends Controller
{
	// Configuramos en el constructor del controlador la autenticación usando el Middleware auth.basic,
	// pero solamente para los métodos de crear, actualizar y borrar.
	public function __construct()
	{
		$this->middleware('auth.basic',['only'=>['store','update','destroy']]);
	}
 
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idVideo)
	{
		// Devolverá todos las reproducciones.
		//return "Mostrando las reproducciones del Video con Id $idVideo";
		$Video=Video::find($idVideo);
 
		if (!$Video)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Video con ese código.'])],404);
		}
 
		return response()->json(['status'=>'ok','data'=>$Video->reproducciones()->get()],200);
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
		if ( !$request->input('Video_id') || !$request->input('Mes') || !$request->input('Year') || !$request->input('Reproducciones')|| !$request->input('Vistas'))
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
		// Insertamos una fila en reproducciones con create pasándole todos los datos recibidos.
		$nuevoReproduccion=$Video->reproducciones()->create($request->all());
 
		// Más información sobre respuestas en http://jsonapi.org/format/
		// Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
		$response = Response::make(json_encode(['data'=>$nuevoReproduccion]), 201)->header('Location','http://ads.deskode.local/api/reproducciones/'.$nuevoReproduccion->IdReproduccion)->header('Content-Type', 'application/json');
		return $response;
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
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($idVideo,$idReproduccion)
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
 
		// El Video existe entonces buscamos el Reproduccion que queremos editar asociado a ese Video.
		$Reproduccion = $Video->comentarios()->find($idReproduccion);
 
		// Si no existe ese Reproduccion devolvemos un error.
		if (!$Reproduccion)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Reproduccion con ese código asociado al Video.'])],404);
		}	
 
 
		// Listado de campos recibidos teóricamente.
		$Mes=$request->input('Mes');
		$Year=$request->input('Year');
		$Reproducciones=$request->input('Reproducciones');
		$Vistas=$request->input('Vistas');
 
		// Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
		// El método de la petición se sabe a través de $request->method();
		if ($request->method() === 'PATCH')
		{
			// Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
			$bandera = false;
 
			// Actualización parcial de campos.
			if ($Mes)
			{
				$Reproduccion->Mes = $Mes;
				$bandera=true;
			}
 
			if ($Year)
			{
				$Reproduccion->Year = $Year;
				$bandera=true;
			}
 
			if ($Reproducciones)
			{
				$Reproduccion->Reproducciones = $Reproducciones;
				$bandera=true;
			}
 
			if ($Vistas)
			{
				$Reproduccion->Vistas = $Vistas;
				$bandera=true;
			}

			if ($bandera)
			{
				// Almacenamos en la base de datos el registro.
				$Reproduccion->save();
				return response()->json(['status'=>'ok','data'=>$Reproduccion], 200);
			}
			else
			{
				// Se devuelve un array errors con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
				// Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del Reproduccion.'])],304);
			}
 
		}
 
		// Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
		if (!$Mes || !$Year || !$Reproducciones || !$Vistas)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);
		}
 
		$Reproduccion->Mes = $Mes;
		$Reproduccion->Year = $Year;
		$Reproduccion->Reproducciones = $Reproducciones;
		$Reproduccion->Vistas = $Vistas;
 
		// Almacenamos en la base de datos el registro.
		$Reproduccion->save();
 
		return response()->json(['status'=>'ok','data'=>$Reproduccion], 200);
	}
 
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idVideo,$idReproduccion)
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
 
		// El Video existe entonces buscamos el Reproduccion que queremos borrar asociado a ese Video.
		$Reproduccion = $Video->reproducciones()->find($idReproduccion);
 
		// Si no existe ese Reproduccion devolvemos un error.
		if (!$Reproduccion)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Reproduccion con ese código asociado a ese Video.'])],404);
		}
 
		// Procedemos por lo tanto a eliminar el Reproduccion.
		$Reproduccion->delete();
 
		// Se usa el código 204 No Content – [Sin Contenido] Respuesta a una petición exitosa que no devuelve un body (como una petición DELETE)
		// Este código 204 no devuelve body así que si queremos que se vea el mensaje tendríamos que usar un código de respuesta HTTP 200.
		return response()->json(['code'=>204,'message'=>'Se ha eliminado el Reproduccion correctamente.'],204);
	}
}
