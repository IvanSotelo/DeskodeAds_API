<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Activamos uso de caché.
use Illuminate\Support\Facades\Cache;

// Necesitaremos el modelo Pantalla para ciertas tareas.
use App\Pantalla;

// Necesitamos la clase Response para crear la respuesta especial con la cabecera de localización en el método Store()
use Response;

class PantallaController extends Controller
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
	public function index()
	{
	    // Activamos la caché de los resultados.
        //  Cache::remember('tabla', $minutes, function()
        $pantallas=Cache::remember('pantallas',20/60, function()
        {
            // Caché válida durante 20 segundos.
            return Pantalla::all();
        });
        // Con caché.
        return response()->json(['Pantallas'=>$pantallas], 200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		// Primero comprobaremos si estamos recibiendo todos los campos.
		if (!$request->input('Categoria_id') || !$request->input('Ubicacion') || !$request->input('Red_id') || !$request->input('Lat') || !$request->input('Lng'))
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
		}

		// Insertamos una fila en Pantalla con create pasándole todos los datos recibidos.
		// En $request->all() tendremos todos los campos del formulario recibidos.
		$nuevoPantalla=Pantalla::create($request->all());

		// Más información sobre respuestas en http://jsonapi.org/format/
		// Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
		$response = Response::make(json_encode(['Pantalla'=>$nuevoPantalla]), 201)->header('Location', 'http://ads.deskode.local/api/v1/pantallas/'.$nuevoPantalla->IdPantalla)->header('Content-Type', 'application/json');
		return $response;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//return "Se muestra Pantalla con id: $id";
		$Pantalla=Pantalla::find($id);

		// Si no existe ese Pantalla devolvemos un error.
		if (!$Pantalla)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una Pantalla con ese código.'])],404);
		}

		return response()->json(['Pantalla'=>$Pantalla],200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Comprobamos si el Pantalla que nos están pasando existe o no.
		$Pantalla=Pantalla::find($id);

		// Si no existe ese Pantalla devolvemos un error.
		if (!$Pantalla)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Pantalla con ese código.'])],404);
		}

		// Listado de campos recibidos teóricamente.
		$Categoria_id=$request->input('Categoria_id');
		$Ubicacion=$request->input('Ubicacion');
		$Red_id=$request->input('Red_id');
		$Lat=$request->input('Lat');
		$Lng=$request->input('Lng');

		// Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
		// El método de la petición se sabe a través de $request->method();
		if ($request->method() === 'PATCH')
		{
			// Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
			$bandera = false;

			// Actualización parcial de campos.
			if ($Categoria_id!=null&&$Categoria_id!='')
			{
				$Pantalla->Categoria_id = $Categoria_id;
				$bandera=true;
			}

			if ($Ubicacion!=null&&$Ubicación!='')
			{
				$Pantalla->Ubicacion = $Ubicacion;
				$bandera=true;
			}

			if ($Red_id!=null&&$Red_id!='')
			{
				$Pantalla->Red_id = $Red_id;
				$bandera=true;
			}

			if ($Lat!=null&&$Lat!='')
			{
				$Pantalla->Lat = $Lat;
				$bandera=true;
			}

			if ($Lng!=null&&$Lng!='')
			{
				$Pantalla->Lng = $Lng;
				$bandera=true;
			}

			if ($bandera)
			{
				// Almacenamos en la base de datos el registro.
				$Pantalla->save();
				return response()->json(['Pantalla'=>$Pantalla], 200);
			}
			else
			{
				// Se devuelve un array errors con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
				// Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato de Pantalla.'])],304);
			}
		}


		// Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
		if (!$Categoria_id || !$Ubicacion || !$Red_id || !$Lat || !$Lng)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);
		}

		$Pantalla->Categoria_id = $Categoria_id;
		$Pantalla->Ubicacion = $Ubicacion;
		$Pantalla->Red_id = $Red_id;
		$Pantalla->Lat = $Lat;
		$Pantalla->Lng = $Lng;

		// Almacenamos en la base de datos el registro.
		$Pantalla->save();
		return response()->json(['Pantalla'=>$Pantalla], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Primero eliminaremos todos los videos de un Pantalla y luego la Pantalla en si mismo.
		// Comprobamos si la Pantalla que nos están pasando existe o no.
		$Pantalla=Pantalla::find($id);

		// Si no existe esa Pantalla devolvemos un error.
		if (!$Pantalla)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una Pantalla con ese código.'])],404);
		}

		// La Pantalla existe entonces buscamos todos los videos asociados a esa Pantalla.
		$videos = $Pantalla->videos; // Sin paréntesis obtenemos el array de todos los videos.

		// Comprobamos si tiene videos esa Pantalla.
		if (sizeof($videos) > 0)
		{
			// Devolveremos un código 409 Conflict - [Conflicto] Cuando hay algún conflicto al procesar una petición, por ejemplo en PATCH, POST o DELETE.
			return response()->json(['code'=>409,'message'=>'Esta Pantalla posee videos y no puede ser eliminado.'],409);
		}

		// Procedemos por lo tanto a eliminar el Pantalla.
		$Pantalla->delete();

		// Se usa el código 204 No Content – [Sin Contenido] Respuesta a una petición exitosa que no devuelve un body (como una petición DELETE)
		// Este código 204 no devuelve body así que si queremos que se vea el mensaje tendríamos que usar un código de respuesta HTTP 200.
		return response()->json(['code'=>204,'message'=>'Se ha eliminado la Pantalla correctamente.'],204);
	}
}
