<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Activamos uso de caché.
use Illuminate\Support\Facades\Cache;

// Necesitaremos el modelo Cliente para ciertas tareas.
use App\Cliente;

// Necesitamos la clase Response para crear la respuesta especial con la cabecera de localización en el método Store()
use Response;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ClienteController extends Controller
{
	// Configuramos en el constructor del controlador la autenticación usando el Middleware auth.basic,
	// pero solamente para los métodos de crear, actualizar y borrar.
//	public function __construct()
//	{
//		$this->middleware('auth.basic',['only'=>['store','update','destroy']]);
//	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

	    // Activamos la caché de los resultados.
        //  Cache::remember('tabla', $minutes, function()
        $clientes=Cache::remember('clientes',20/60, function()
        {
            // Caché válida durante 20 segundos.
            return Cliente::all();
        });
        // Con caché.
        return response()->json(['Clientes'=>$clientes], 200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		// Primero comprobaremos si estamos recibiendo todos los campos.
		if (!$request->input('Usuario_id') || !$request->input('Nombre') || !$request->input('Telefono') || !$request->input('Direccion') || !$request->input('EMail') || !$request->input('RFC'))
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
		}

		// Insertamos una fila en Cliente con create pasándole todos los datos recibidos.
		// En $request->all() tendremos todos los campos del formulario recibidos.
		$nuevoCliente=Cliente::create($request->all());

		// Más información sobre respuestas en http://jsonapi.org/format/
		// Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
		$response = Response::make(json_encode(['Cliente'=>$nuevoCliente]), 201)->header('Location', 'http://ads.deskode.local/api/clientes/'.$nuevoCliente->IdCliente)->header('Content-Type', 'application/json');
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
		//return "Se muestra Cliente con id: $id";
		$Cliente=Cliente::find($id);

		// Si no existe ese Cliente devolvemos un error.
		if (!$Cliente)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Cliente con ese código.'])],404);
		}

		return response()->json(['Cliente'=>$Cliente],200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Comprobamos si el Cliente que nos están pasando existe o no.
		$Cliente=Cliente::find($id);

		// Si no existe ese Cliente devolvemos un error.
		if (!$Cliente)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Cliente con ese código.'])],404);
		}

		// Listado de campos recibidos teóricamente.
		$nombre=$request->input('Nombre');
		$telefono=$request->input('Telefono');
		$direccion=$request->input('Direccion');
		$email=$request->input('EMail');
		$rfc=$request->input('RFC');

		// Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
		// El método de la petición se sabe a través de $request->method();
		if ($request->method() === 'PATCH')
		{
			// Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
			$bandera = false;

			// Actualización parcial de campos.
			if ($nombre!=null&&$nombre!='')
			{
				$Cliente->Nombre = $nombre;
				$bandera=true;
			}

			if ($telefono!=null&&$telefono!='')
			{
				$Cliente->Telefono = $telefono;
				$bandera=true;
			}

			if ($direccion!=null&&$direccion!='')
			{
				$Cliente->Direccion = $direccion;
				$bandera=true;
			}

 			if ($email!=null&&$email!='')
			{
				$Cliente->EMail = $email;
				$bandera=true;
			}

			if ($rfc!=null&&$rfc!='')
			{
				$Cliente->RFC = $rfc;
				$bandera=true;
			}

			if ($bandera)
			{
				// Almacenamos en la base de datos el registro.
				$Cliente->save();
				return response()->json(['Cliente'=>$Cliente], 200);
			}
			else
			{
				// Se devuelve un array errors con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
				// Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato de Cliente.'])],304);
			}
		}


		// Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
		if (!$nombre || !$telefono || !$direccion || !$email || !$rfc)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);
		}

		$Cliente->Nombre = $nombre;
		$Cliente->Telefono = $telefono;
		$Cliente->Direccion = $direccion;
		$Cliente->EMail = $email;
		$Cliente->RFC = $rfc;

		// Almacenamos en la base de datos el registro.
		$Cliente->save();
		return response()->json(['Cliente'=>$Cliente], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	// Primero eliminaremos todos los videos de un Cliente y luego el Cliente en si mismo.
		// Comprobamos si el Cliente que nos están pasando existe o no.
		$Cliente=Cliente::find($id);

		// Si no existe ese Cliente devolvemos un error.
		if (!$Cliente)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Cliente con ese código.'])],404);
		}

		// El Cliente existe entonces buscamos todos los videos asociados a ese Cliente.
		$videos = $Cliente->videos; // Sin paréntesis obtenemos el array de todos los videos.

		// Comprobamos si tiene videos ese Cliente.
		if (sizeof($videos) > 0)
		{
			// Devolveremos un código 409 Conflict - [Conflicto] Cuando hay algún conflicto al procesar una petición, por ejemplo en PATCH, POST o DELETE.
			return response()->json(['code'=>409,'message'=>'Este Cliente posee videos y no puede ser eliminado.'],409);
		}

		// Procedemos por lo tanto a eliminar el Cliente.
		$Cliente->delete();

		// Se usa el código 204 No Content – [Sin Contenido] Respuesta a una petición exitosa que no devuelve un body (como una petición DELETE)
		// Este código 204 no devuelve body así que si queremos que se vea el mensaje tendríamos que usar un código de respuesta HTTP 200.
		return response()->json(['code'=>204,'message'=>'Se ha eliminado el Cliente correctamente.'],204);
	}
}
