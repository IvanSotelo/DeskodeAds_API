# Deskode Ads API

La Api para Deskode Ads es un servicio web REST con todas las funciones para realizar peticiones de lectura y escritura que utiliza OAuth2 para la autenticacion. Para mas informacion visita [Deskode.com](http://www.deskode.com).

## Construccion de la Solicitud

Cada petición HTTP consiste en un método HTTP, un metodo y una lista de parámetros. A lo largo de la documentación, estas solicitudes tienen el formato como el siguiente ejemplo.

{METHOD}|http://ads.deskode.com/api/{Endpoint}

1. Método
La mayor parte de los endpoints de la API de Deskode Ads tienen soporte a múltiples acciones. Cada acción se define por el mismo método HTTP. Estos métodos generalmente siguen las siguientes pautas.

MÉTODO |Descripción|Ejemplo
------|---|---------
GET|Recupera un JSON de un recurso|GET /videos devuelve la informacion de un video
POST|Añade nuevos recursos a una colección. Este método generalmente requiere parámetros adicionales|POST /clientes/pagos al cliente crea un nuevo pago
PATCH|Modifica un recurso. El cuerpo contendrá la nueva representación del recurso.|PATCH /videos/[video_id] le permite cambiar los campos del video [video_id]
DELETE	| Elimina un recurso existente |	DELETE /videos/[video_id] borra el video [video_id]

2. Endpoint
Un Endpoint de la API es un camino que identifica de forma exclusiva un recurso. Para hacer una petición HTTP añade un Endpoint hasta el final de http://ads.deskode.com/api/. La respuesta de un Endpoint será JSON, y contienen uno o más recursos.

## Metodos

METODO|URL|DESCRIPCION
------|---|---------
POST  |/auth|Autoriza el acceso a un usuario.
GET  |/clientes|Obtiene una lista de los clientes.
POST  |/clientes|Crea un cliente.
GET  |/clientes/{cliente}|Obtiene un cliente.
DELETE  |/clientes/{cliente}|Elimina un cliente.
PATCH  |/clientes/{cliente}|Edita un cliente.
GET  |/clientes/{cliente}/compras|Obtiene una lista de las compras de un cliente.
GET  |/clientes/{cliente}/compras/{compra} |Obtiene la compra de un cliente.
GET  |/clientes/{cliente}/pagos|Obtiene una lista de los pagos de un cliente.
POST  |/clientes/{cliente}/pagos|Crea el pago un cliente.
DELETE  |/clientes/{cliente}/pagos/{pago}|Elimina el pago de un cliente.
PATCH  |/clientes/{cliente}/pagos/{pago}|Edita un pago de un cliente.
GET  |/clientes/{cliente}/videos|Obtiene una lista de los videos de un cliente.
GET  |/clientes/{cliente}/videos/{video}|Obtiene el video de un cliente.
GET  |/pagos|Obtiene una lista de los pagos.
GET  |/pagos/{pago}|Obtiene un pago.
GET  |/vendedores|Obtiene una lista de los vendedores.
POST  |/vendedores|Crea un vendedor.
GET  |/vendedores/{vendedor}|Obtiene un vendedor.
DELETE  |/vendedores/{vendedor}|Elimina un vendedor.
PATCH  |/vendedores/{vendedor}|Edita un vendedor.
GET  |/vendedores/{vendedor}/ventas|Obtiene una lista de las ventas de un vendedor.
GET  |/vendedores/{vendedor}/ventas/{venta}|Obtiene la venta de un vendedor.
GET  |/ventas|Obtiene una lista de las ventas.
POST  |/ventas|Crea una venta.
GET  |/ventas/{venta}|Obtiene una venta.
DELETE  |/ventas/{venta}|Elimina una venta.
PATCH  |/ventas/{venta}|Edita una venta.
GET  |/ventas/{venta}/videos|Obtiene una lista de los videos de un venta.
GET  |/ventas/{venta}/videos/{video}|Obtiene el video de un venta.
GET  |/pantallas|Obtiene una lista de las pantallas.
POST  |/pantallas|Crea una pantalla.
GET  |/pantallas/{pantalla}|Obtiene una pantalla.
DELETE  |/pantallas/{pantalla}|Elimina una pantalla.
PATCH  |/pantallas/{pantalla}|Edita una pantalla.
GET  |/pantallas/{pantalla}/videos|Obtiene una lista de los videos de una pantalla.
GET  |/pantallas/{pantalla}/videos/{video}|Obtiene el video de una pantalla.
GET  |/pantallas/{categoria}/categorias|Obtiene una lista de la pantallas de una categoria.
GET  |/pantallas/{pantalla}/categorias/{categoria}|Obtiene una pantalla de una categoria.
GET  |/categorias|Obtiene una lista de las categorias.
POST  |/categorias|Crea una categoria.
GET  |/categorias/{categoria}|Obtiene una categoria.
DELETE  |/categorias/{categoria}|Elimina una categoria.
PATCH  |/categorias/{categoria}|Edita una categoria.
GET  |/videos|Obtiene una lista de las videos.
POST  |/videos|Crea una video.
GET  |/videos/{video}|Obtiene una video.
DELETE  |/videos/{video}|Elimina una video.
PATCH  |/videos/{video}|Edita una video.
GET  |/videos/{video}/comentarios|Obtiene una lista de los comentarios de un video.
POST  |/videos/{video}/comentarios|Crea un comentario de un video.
DELETE  |/videos/{video}/comentarios/{comentario}|Elimina el comentario de un video.
PATCH  |/videos/{video}/comentarios/{comentario}|Edita el comentario de un video.
GET  |/videos/{video}/reproducciones|Obtiene una lista de las reproducciones de un video.
POST  |/videos/{video}/reproducciones|Crea una reproduccion de un video.
DELETE  |/videos/{video}/reproducciones/{reproduccion}|Elimina la reproduccion de un video.
PATCH  |/videos/{video}/reproducciones/{reproduccion}|Edita la reproduccion de un video.
GET  |/comentarios|Obtiene una lista de los comentarios.
GET  |/comentarios/{comentario}|Obtiene un comentario.
GET  |/reproducciones|Obtiene una lista de las reproducciones.
GET  |/reproducciones/{reproduccion}|Obtiene una reproduccion.