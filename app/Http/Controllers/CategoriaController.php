<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Activamos uso de caché.
use Illuminate\Support\Facades\Cache;

// Necesitaremos el modelo Categoria para ciertas tareas.
use App\Categoria;

// Necesitamos la clase Response para crear la respuesta especial con la cabecera de localización en el método Store()
use Response;

class CategoriaController extends Controller
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
		// Devolverá todos las Categorias.
		//return "Mostrando todos las Categorias de la base de datos.";
		// return Categoria::all();  No es lo más correcto por que se devolverían todos los registros. Se recomienda usar Filtros.
		// Se debería devolver un objeto con una propiedad como mínimo data y el array de resultados en esa propiedad.
		// A su vez también es necesario devolver el código HTTP de la respuesta.
		//php http://elbauldelprogramador.com/buenas-practicas-para-el-diseno-de-una-api-RESTful-pragmatica/
		// https://cloud.google.com/storage/docs/json_api/v1/status-codes

	    // Activamos la caché de los resultados.
        //  Cache::remember('tabla', $minutes, function()
        $categorias=Cache::remember('categorias',20/60, function()
        {
            // Caché válida durante 20 segundos.
            return Categoria::all();
        });
        // Con caché.
        return response()->json(['Categorias'=>$categorias], 200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		// Primero comprobaremos si estamos recibiendo todos los campos.
		if (!$request->input('Categoria'))
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
		}

		// Insertamos una fila en Fabricante con create pasándole todos los datos recibidos.
		// En $request->all() tendremos todos los campos del formulario recibidos.
		$nuevoCategoria=Categoria::create($request->all());

		// Más información sobre respuestas en http://jsonapi.org/format/
		// Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
		$response = Response::make(json_encode(['Categoria'=>$nuevoCategoria]), 201)->header('Location', 'http://ads.deskode.local/api/categorias/'.$nuevoCategoria->IdCategoria)->header('Content-Type', 'application/json');
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
		//return "Se muestra Categoria con id: $id";
		$Categoria=Categoria::find($id);

		// Si no existe ese Categoria devolvemos un error.
		if (!$Categoria)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Categoria con ese código.'])],404);
		}

		return response()->json(['Categoria'=>$Categoria],200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Comprobamos si el Categoria que nos están pasando existe o no.
		$Categoria=Categoria::find($id);

		// Si no existe ese Categoria devolvemos un error.
		if (!$Categoria)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Categoria con ese código.'])],404);
		}

		// Listado de campos recibidos teóricamente.
		$Categoria1=$request->input('Categoria');

		// Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
		// El método de la petición se sabe a través de $request->method();
		if ($request->method() === 'PATCH')
		{
			// Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
			$bandera = false;

			// Actualización parcial de campos.
			if ($Categoria1!=null&&$Categoria1!='')
			{
				$Categoria->Categoria = $Categoria1;
				$bandera=true;
			}

			if ($bandera)
			{
				// Almacenamos en la base de datos el registro.
				$Categoria->save();
				return response()->json(['Categoria'=>$Categoria], 200);
			}
			else
			{
				// Se devuelve un array errors con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
				// Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato de Categoria.'])],304);
			}
		}


		// Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
		if (!$Categoria1)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);
		}

		$Categoria->Categoria = $Categoria1;

		// Almacenamos en la base de datos el registro.
		$Categoria->save();
		return response()->json(['Categoria'=>$Categoria], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Primero eliminaremos todos los videos y las pantallas de un Categoria y luego el Categoria en si mismo.
		// Comprobamos si el Categoria que nos están pasando existe o no.
		$Categoria=Categoria::find($id);

		// Si no existe ese Categoria devolvemos un error.
		if (!$Categoria)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una Categoria con ese código.'])],404);
		}

		// El Categoria existe entonces buscamos todos los videos asociados a ese Categoria.
		$videos = $Categoria->videos; // Sin paréntesis obtenemos el array de todos los videos.

		// Comprobamos si tiene videos ese Categoria.
		if (sizeof($videos) > 0)
		{
			// Devolveremos un código 409 Conflict - [Conflicto] Cuando hay algún conflicto al procesar una petición, por ejemplo en PATCH, POST o DELETE.
			return response()->json(['code'=>409,'message'=>'Esta Categoria posee videos y no puede ser eliminado.'],409);
		}

		// El Categoria existe entonces buscamos todos los pantallas asociados a ese Categoria.
		$pantallas = $Categoria->pantallas; // Sin paréntesis obtenemos el array de todos los pantallas.

		// Comprobamos si tiene pantallas ese Categoria.
		if (sizeof($pantallas) > 0)
		{
			// Devolveremos un código 409 Conflict - [Conflicto] Cuando hay algún conflicto al procesar una petición, por ejemplo en PATCH, POST o DELETE.
			return response()->json(['code'=>409,'message'=>'Esta Categoria posee pantallas y no puede ser eliminado.'],409);
		}

		// Procedemos por lo tanto a eliminar el Categoria.
		$Categoria->delete();

		// Se usa el código 204 No Content – [Sin Contenido] Respuesta a una petición exitosa que no devuelve un body (como una petición DELETE)
		// Este código 204 no devuelve body así que si queremos que se vea el mensaje tendríamos que usar un código de respuesta HTTP 200.
		return response()->json(['code'=>204,'message'=>'Se ha eliminado la Categoria correctamente.'],204);
	}
}
