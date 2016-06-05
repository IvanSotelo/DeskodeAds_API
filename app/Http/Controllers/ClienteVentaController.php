<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Necesita los dos modelos Cliente y Venta
use App\Cliente;
use App\Venta;

// Activamos uso de caché.
use Illuminate\Support\Facades\Cache;

class ClienteVentaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idCliente)
	{
		// Devolverá todos los ventas.
		//return "Mostrando los ventas del fabricante con Id $idCliente";
		$Cliente=Cliente::find($idCliente);

		if (! $Cliente)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un Cliente con ese código.'])],404);
		}
		// Activamos la caché de los resultados.
		// Como el closure necesita acceder a la variable $ fabricante tenemos que pasársela con use($Clientes)
		// Para acceder a los modelos no haría falta puesto que son accesibles a nivel global dentro de la clase.
		//  Cache::remember('tabla', $minutes, function()
		$ventas=Cache::remember('claveVentas',2, function() use ($Cliente)
		{
			// Caché válida durante 2 minutos.
			return $Cliente->ventas()->get();
		});

		// Respuesta con caché:
		return response()->json(['Ventas'=>$ventas],200);

		// Respuesta sin caché:
		//return response()->json(['status'=>'ok','data'=>$Cliente->ventas()->get()],200);
		//return response()->json(['status'=>'ok','data'=>$Cliente->aviones],200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($idCliente,$idVenta)
	{
		//
		return "Se muestra Venta $idVenta del Vendedor $idCliente";
	}
}
