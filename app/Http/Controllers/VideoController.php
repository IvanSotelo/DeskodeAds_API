<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Activamos uso de caché.
use Illuminate\Support\Facades\Cache;

// Necesitaremos el modelo Video para ciertas tareas.
use App\Video;

// Necesitamos la clase Response para crear la respuesta especial con la cabecera de localización en el método Store()
use Response;

class VideoController extends Controller
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
        $videos=Cache::remember('videos',20/60, function()
        {
            // Caché válida durante 20 segundos.
            return Video::all();
        });
        // Con caché.
        return response()->json(['videos'=>$videos], 200);
		// Devolverá todos los videos.
		//return response()->json(['status'=>'ok','data'=>Video::all()], 200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		// Primero comprobaremos si estamos recibiendo todos los campos.
		if (!$request->input('Pantalla_id') || !$request->input('Cliente_id') || !$request->input('Categoria_id') || !$request->input('Venta_id') || !$request->input('FechaAlta') || !$request->input('FechaBaja') || !$request->input('URL'))
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
		}

		// Insertamos una fila en Video con create pasándole todos los datos recibidos.
		// En $request->all() tendremos todos los campos del formulario recibidos.
		$nuevoVideo=Video::create($request->except('Pantalla_id'));
		$nuevoVideo->pantallas()->attach($request->only('Pantalla_id'));

		// Más información sobre respuestas en http://jsonapi.org/format/
		// Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
		$response = Response::make(json_encode(['Video'=>$nuevoVideo]), 201)->header('Location', 'http://ads.deskode.local/api/videos/'.$nuevoVideo->IdVideo)->header('Content-Type', 'application/json');
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
		//return "Se muestraVideo con id: $id";
		$Video=Video::find($id);

		// Si no existe ese Video devolvemos un error.
		if (!$Video)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Video con ese código.'])],404);
		}

		return response()->json(['video'=>$Video],200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Comprobamos si el Video que nos están pasando existe o no.
		$Video=Video::find($id);

		// Si no existe ese Video devolvemos un error.
		if (!$Video)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Video con ese código.'])],404);
		}

		// Listado de campos recibidos teóricamente.
		$Cliente_id=$request->input('Cliente_id');
		$Categoria_id=$request->input('Categoria_id');
		$Pantalla_id=$request->input('Pantalla_id');
		$Venta_id=$request->input('Venta_id');
		$FechaAlta=$request->input('FechaAlta');
		$FechaBaja=$request->input('FechaBaja');
		$URL=$request->input('URL');

		// Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
		// El método de la petición se sabe a través de $request->method();
		if ($request->method() === 'PATCH')
		{
			// Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
			$bandera = false;

			// Actualización parcial de campos.
			if ($Cliente_id!=null&&$Cliente_id!='')
			{
				$Video->Cliente_id = $Cliente_id;
				$bandera=true;
			}

			if ($Categoria_id!=null&&$Categoria_id!='')
			{
				$Video->Categoria_id = $Categoria_id;
				$bandera=true;
			}

			if ($Pantalla_id!=null&&$Pantalla_id!='')
			{
				$Video->Pantalla_id = $Pantalla_id;
				$bandera=true;
			}

			if ($Venta_id!=null&&$Venta_id!='')
			{
				$Video->Venta_id = $Venta_id;
				$bandera=true;
			}

			if ($FechaAlta!=null&&$FechaAlta!='')
			{
				$Video->FechaAlta = $FechaAlta;
				$bandera=true;
			}

			if ($FechaBaja!=null&&$FechaBaja!='')
			{
				$Video->FechaBaja = $FechaBaja;
				$bandera=true;
			}

			if ($URL!=null&&$URL!='')
			{
				$Video->URL = $URL;
				$bandera=true;
			}

			if ($bandera)
			{
				// Almacenamos en la base de datos el registro.
				$Video->save();
				return response()->json(['video'=>$Video], 200);
			}
			else
			{
				// Se devuelve un array errors con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
				// Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato de Video.'])],304);
			}
		}


		// Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
		if (!$Cliente_id || !$Categoria_id || !$Pantalla_id || !$Venta_id || !$FechaAlta || !$FechaBaja || !$URL)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);
		}

		$Video->Cliente_id = $Cliente_id;
		$Video->Categoria_id = $Categoria_id;
		$Video->Pantalla_id = $Pantalla_id;
		$Video->Venta_id = $Venta_id;
		$Video->FechaAlta = $FechaAlta;
		$Video->FechaBaja = $FechaBaja;
		$Video->URL = $URL;

		// Almacenamos en la base de datos el registro.
		$Video->save();
		return response()->json(['video'=>$Video], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	// Primero eliminaremos todos los comentarios de un Video y luego el Video en si mismo.
		// Comprobamos si el Video que nos están pasando existe o no.
		$Video=Video::find($id);

		// Si no existe ese Video devolvemos un error.
		if (!$Video)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Video con ese código.'])],404);
		}

		// El Video existe entonces buscamos todos los comentarios asociados a ese Video.
		$comentarios = $Video->comentarios; // Sin paréntesis obtenemos el array de todos los videos.

		// Comprobamos si tiene comentarios ese Video.
		if (sizeof($comentarios) > 0)
		{
			// Devolveremos un código 409 Conflict - [Conflicto] Cuando hay algún conflicto al procesar una petición, por ejemplo en PATCH, POST o DELETE.
			return response()->json(['code'=>409,'message'=>'Este Video posee comentarios y no puede ser eliminado.'],409);
		}

		// El Video existe entonces buscamos todos los reproducciones asociados a ese Video.
		$reproducciones = $Video->reproducciones; // Sin paréntesis obtenemos el array de todos las reproducciones.

		// Comprobamos si tiene reproducciones ese Video.
		if (sizeof($reproducciones) > 0)
		{
			// Devolveremos un código 409 Conflict - [Conflicto] Cuando hay algún conflicto al procesar una petición, por ejemplo en PATCH, POST o DELETE.
			return response()->json(['code'=>409,'message'=>'Este Video posee reproducciones y no puede ser eliminado.'],409);
		}

		// Procedemos por lo tanto a eliminar el Video.
		$Video->delete();

		// Se usa el código 204 No Content – [Sin Contenido] Respuesta a una petición exitosa que no devuelve un body (como una petición DELETE)
		// Este código 204 no devuelve body así que si queremos que se vea el mensaje tendríamos que usar un código de respuesta HTTP 200.
		return response()->json(['code'=>204,'message'=>'Se ha eliminado el Video correctamente.'],204);
	}
}
