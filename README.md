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


GET <BaseUrl>/api/juegos


### Query Params:

- **Ordenamiento:**
  - `orderBy` : Campo por el que se desea ordenar los resultados. Los campos válidos incluyen:
    - `id_juegos`: ordena los juegos por ID.
    - `nombre`: Ordena los juegos por nombre.
    - `fecha_lanzamiento`: Ordena los juegos por fecha.
    - `precio`: Ordena los juegos por precio.

**ejemplo de ordenamiento

GET <BaseUrl>/api/juegos?orderBy=nombre

- **Filtro:**
 - `filterBy` : Campo por el que se desea filtrar los resultados. Los campos válidos incluyen:
    - `nombre`: Filtra los juegos por el nombre especificado (filtra los juegos cuyo nombre contiene el valor del filtro dado).
    - `precioigual`: Filtra los juegos cuyo precio sea el especificado.
    - `preciomenor`: Filtra los juegos cuyo precio sea menor al especificado.
    - `preciomayor`: Filtra los juegos cuyo precio sea mayor al especificado.
    - `preciomenorigual`: Filtra los juegos cuyo precio sea menor o igual al especificado.
    - `preciomayorigual`: Filtra los juegos cuyo precio sea amyor o igual al especificado.

- `filter` : Campo por el que se desea filtrar los resultados.

**ejemplo para filtrar

obtener todos los juegos con un precio igual a 59.99

GET <BaseUrl>/api/juegos?filterBy=precioigual&filter=59.99

obtener todos los juegos con un precio menor o igual a 120.36

GET <BaseUrl>/api/juegos?filterBy=preciomenorigual&filter=120.36

obtener todos los juegos cuyo nombre contengan league

GET <BaseUrl>/api/juegos?filterBy=nombre&filter=league


    

