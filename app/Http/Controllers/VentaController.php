<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Necesitaremos el modelo Venta para ciertas tareas.
use App\Venta;

// Necesitamos la clase Response para crear la respuesta especial con la cabecera de localización en el método Store()
use Response;

class VentaController extends Controller
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
		// Devolverá todos las ventas.
		return response()->json(['status'=>'ok','data'=>Venta::all()], 200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		// Primero comprobaremos si estamos recibiendo todos los campos.
		if (!$request->input('Cliente_id') || !$request->input('Vendedor_id') || !$request->input('Estatus') || !$request->input('Precio') || !$request->input('Paquete'))
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
		}
 
		// Insertamos una fila en Venta con create pasándole todos los datos recibidos.
		// En $request->all() tendremos todos los campos del formulario recibidos.
		$nuevoVenta=Venta::create($request->all());
 
		// Más información sobre respuestas en http://jsonapi.org/format/
		// Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
		$response = Response::make(json_encode(['data'=>$nuevoVenta]), 201)->header('Location', 'http://ads.deskode.local/api/ventas/'.$nuevoVenta->IdVenta)->header('Content-Type', 'application/json');
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
		//return "Se muestra Venta con id: $id";
		$Venta=Venta::find($id);
 
		// Si no existe ese Venta devolvemos un error.
		if (!$Venta)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Venta con ese código.'])],404);
		}
 
		return response()->json(['status'=>'ok','data'=>$Venta],200);
	}
  
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Comprobamos si el Venta que nos están pasando existe o no.
		$Venta=Venta::find($id);
 
		// Si no existe ese Venta devolvemos un error.
		if (!$Venta)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un venta con ese código.'])],404);
		}		
 
		// Listado de campos recibidos teóricamente.
		$Cliente_id=$request->input('Cliente_id');
		$Vendedor_id=$request->input('Vendedor_id');
		$Estatus=$request->input('Estatus');
		$Precio=$request->input('Precio');
		$Paquete=$request->input('Paquete');

		// Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
		// El método de la petición se sabe a través de $request->method();
		if ($request->method() === 'PATCH')
		{
			// Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
			$bandera = false;
 
			// Actualización parcial de campos.
			if ($Cliente_id)
			{
				$Venta->Cliente_id = $Cliente_id;
				$bandera=true;
			}

			if ($Vendedor_id)
			{
				$Venta->Vendedor_id = $Vendedor_id;
				$bandera=true;
			}

			if ($Estatus)
			{
				$Venta->Estatus = $Estatus;
				$bandera=true;
			}

			if ($Precio)
			{
				$Venta->Precio = $Precio;
				$bandera=true;
			}

			if ($Paquete)
			{
				$Venta->Paquete = $Paquete;
				$bandera=true;
			}			
 
			if ($bandera)
			{
				// Almacenamos en la base de datos el registro.
				$Venta->save();
				return response()->json(['status'=>'ok','data'=>$Venta], 200);
			}
			else
			{
				// Se devuelve un array errors con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
				// Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato de Venta.'])],304);
			}
		}
 
 
		// Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
		if (!$Cliente_id || !$Vendedor_id || !$Estatus || !$Precio || !$Paquete)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);
		}
 
		$Venta->Cliente_id = $Cliente_id;
		$Venta->Vendedor_id = $Vendedor_id;
		$Venta->Estatus = $Estatus;
		$Venta->Precio = $Precio;
		$Venta->Paquete = $Paquete;
 
		// Almacenamos en la base de datos el registro.
		$Venta->save();
		return response()->json(['status'=>'ok','data'=>$Venta], 200);
	}
 
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	// Primero eliminaremos todos los videos de un Venta y luego el Venta en si mismo.
		// Comprobamos si el Venta que nos están pasando existe o no.
		$Venta=Venta::find($id);
 
		// Si no existe ese Venta devolvemos un error.
		if (!$Venta)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una Venta con ese código.'])],404);
		}		
 
		// El Venta existe entonces buscamos todos los videos asociados a ese Venta.
		$videos = $Venta->videos; // Sin paréntesis obtenemos el array de todos los videos.
 
		// Comprobamos si tiene videos ese Venta.
		if (sizeof($videos) > 0)
		{
			// Devolveremos un código 409 Conflict - [Conflicto] Cuando hay algún conflicto al procesar una petición, por ejemplo en PATCH, POST o DELETE.
			return response()->json(['code'=>409,'message'=>'Esta Venta posee videos y no puede ser eliminado.'],409);
		}
 
		// Procedemos por lo tanto a eliminar el Venta.
		$Venta->delete();
 
		// Se usa el código 204 No Content – [Sin Contenido] Respuesta a una petición exitosa que no devuelve un body (como una petición DELETE)
		// Este código 204 no devuelve body así que si queremos que se vea el mensaje tendríamos que usar un código de respuesta HTTP 200.
		return response()->json(['code'=>204,'message'=>'Se ha eliminado la Venta correctamente.'],204);
	}
}
