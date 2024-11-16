# Lista de Juegos

## Integrantes:
* mariano alberto menendez
* teo ivan blas garcia


## Descripción:
Tercera entrega del Trabajo Práctico Especial de Web 2 Tudai Grupo 26 Catalogo de juegos. Es un servicio web de tipo RESTFul de una base de datos con su tabla de juegos y companias de dichos juegos. Hay una relacion 1 a N, tanto entre juegos y companias. 
Además se usa una tabla de usuarios para los accesos (login).
Al visualizar los datos de los Juegos, se traen también los correspondientes datos del nombre de la compania 


## tablas

la tabla juegos tiene:
* id_juegos
* nombre
* fecha_lanzamiento
* modalidad
* plataformas
* id_compania

la tabla companias tiene:
* id_compania
* nombre
* fecha_fundacion
* oficinas_centrales
* sitio_web

la tabla usuarios tiene:
* id_usuario
* usuario
* password
* rol

## DER
![Diagrama Entidad Relacion](/db_juegos.png)

## ENDPOINTS
/api/usuarios/token

GET /api/juegos
GET /api/juegos/:id
POST /api/juegos
PUT /api/juegos/:id
DELETE /api/juegos/:id


GET /api/companias
GET /api/companias/:id
POST /api/companias
PUT /api/companias/:id


## AUTENTICACION

Para realizar acciones como borrar, modificar o agregar un nuevo juego o compania, es necesario que los usuarios estén autenticados. Para ello, deben identificarse utilizando su nombre de usuario y contraseña (por ejemplo: webadmin y admin) a través de la autenticación básic (Basic Authentication). Esta autenticación se realiza enviando una solicitud GET al endpoint /api/usuarios/token, el cual devuelve un token JWT codificado. Este token debe ser copiado y enviado en cada operación como un Bearer Token, incluyéndolo en el encabezado de autorización (Authorization: Bearer tokenJWT).

* GET /api/usuarios/token
Este endpoint permite a los usuarios obtener un token JWT. Para utilizarlo, se deben enviar las credenciales en el encabezado de la solicitud en formato Base64 (usuario:contraseña).

* nombre usuario: webadmin
* password: admin

## JUEGOS

## GET `<BaseUrl>/api/juegos`
Devuelve los juegos disponibles en la base datos, permitiendo aplicar filtros y ordenamiento de los resultados.
### ejemplo de uso

```http
GET <BaseUrl>/api/juegos
