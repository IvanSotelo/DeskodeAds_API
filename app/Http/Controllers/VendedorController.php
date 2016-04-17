<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Necesitaremos el modelo Vendedor para ciertas tareas.
use App\Vendedor;

// Necesitamos la clase Response para crear la respuesta especial con la cabecera de localización en el método Store()
use Response;

class VendedorController extends Controller
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
	public function index()
	{
		return response()->json(['status'=>'ok','data'=>Vendedor::all()], 200);
	}
 
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		// Primero comprobaremos si estamos recibiendo todos los campos.
		if (!$request->input('Usuario_id') || !$request->input('Nombre') || !$request->input('Apellido') || !$request->input('Telefono'))
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
		}
 
		// Insertamos una fila en Vendedor con create pasándole todos los datos recibidos.
		// En $request->all() tendremos todos los campos del formulario recibidos.
		$nuevoVendedor=Vendedor::create($request->all());
 
		// Más información sobre respuestas en http://jsonapi.org/format/
		// Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
		$response = Response::make(json_encode(['data'=>$nuevoVendedor]), 201)->header('Location', 'http://ads.deskode.local/api/vendedores/'.$nuevoVendedor->IdVendedor)->header('Content-Type', 'application/json');
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
		//return "Se muestra Vendedor con id: $id";
		$Vendedor=Vendedor::find($id);
 
		// Si no existe ese Vendedor devolvemos un error.
		if (!$Vendedor)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Vendedor con ese código.'])],404);
		}
 
		return response()->json(['status'=>'ok','data'=>$Vendedor],200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Comprobamos si el Vendedor que nos están pasando existe o no.
		$Vendedor=Vendedor::find($id);
 
		// Si no existe ese Vendedor devolvemos un error.
		if (!$Vendedor)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Cliente con ese código.'])],404);
		}		
 
		// Listado de campos recibidos teóricamente.
		$nombre=$request->input('Nombre');
		$apellido=$request->input('Apellido');
		$telefono=$request->input('Telefono');

		// Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
		// El método de la petición se sabe a través de $request->method();
		if ($request->method() === 'PATCH')
		{
			// Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
			$bandera = false;
 
			// Actualización parcial de campos.
			if ($nombre)
			{
				$Vendedor->Nombre = $nombre;
				$bandera=true;
			}

			if ($apellido)
			{
				$Vendedor->Apellido = $apellido;
				$bandera=true;
			}

			if ($telefono)
			{
				$Vendedor->Telefono = $telefono;
				$bandera=true;
			}			
 
			if ($bandera)
			{
				// Almacenamos en la base de datos el registro.
				$Vendedor->save();
				return response()->json(['status'=>'ok','data'=>$Vendedor], 200);
			}
			else
			{
				// Se devuelve un array errors con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
				// Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato de Vendedor.'])],304);
			}
		}
 
 
		// Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
		if (!$nombre || !$apellido || !$telefono)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);
		}
 
		$Vendedor->Nombre = $nombre;
		$Vendedor->Apellido = $apellido;
		$Vendedor->Telefono = $telefono;
 
		// Almacenamos en la base de datos el registro.
		$Vendedor->save();
		return response()->json(['status'=>'ok','data'=>$Vendedor], 200);
	}
 
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	// Primero eliminaremos todos los videos de un Vendedor y luego el Vendedor en si mismo.
		// Comprobamos si el CVendedorque nos están pasando existe o no.
		$Vendedor=Vendedor::find($id);
 
		// Si no existe ese Vendedor devolvemos un error.
		if (!$Vendedor)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Vendedor con ese código.'])],404);
		}		
  
		// Procedemos por lo tanto a eliminar el Vendedor.
		$Vendedor->delete();
 
		// Se usa el código 204 No Content – [Sin Contenido] Respuesta a una petición exitosa que no devuelve un body (como una petición DELETE)
		// Este código 204 no devuelve body así que si queremos que se vea el mensaje tendríamos que usar un código de respuesta HTTP 200.
		return response()->json(['code'=>204,'message'=>'Se ha eliminado el Vendedor correctamente.'],204);
	}
}
