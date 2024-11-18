# Lista de Juegos

## Integrantes:
* mariano alberto menendez
* teo ivan blas garcia


## Descripción:
Tercera entrega del Trabajo Práctico Especial de Web 2 Tudai Grupo 28 Catalogo de juegos. Es un servicio web de tipo restful de una base de datos con su tabla de juegos y companias de dichos juegos. Hay una relacion 1 a N, tanto entre juegos y companias. 
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

  **GET** `<<BaseUrl>>/api/usuarios/token`

  **GET** `<<BaseUrl>>/api/juegos`  
  **GET** `<<BaseUrl>>/api/juegos/:id`  
  **POST** `<<BaseUrl>>/api/juegos`  
  **PUT** `<<BaseUrl>>/api/juegos/:id`  
  **DELETE** `<<BaseUrl>>/api/juegos/:id`

  **GET** `<<BaseUrl>>/api/companias`  
  **GET** `<<BaseUrl>>/api/companias/:id`  
  **POST** `<<BaseUrl>>/api/companias`  
  **PUT** `<<BaseUrl>>/api/companias`  

  ---


## AUTENTICACION

Para realizar acciones como borrar, modificar o agregar un nuevo juego o compania, es necesario que los usuarios estén autenticados. Para ello, deben identificarse utilizando su nombre de usuario y contraseña (usuario: webadmin, password: admin) a través de la autenticación básic. Esta autenticación se realiza enviando una solicitud GET al endpoint /api/usuarios/token, el cual devuelve un token JWT codificado. Este token debe ser copiado y enviado en cada operación como un Bearer Token, incluyéndolo en el encabezado de autorización.

- **GET** `<<BaseUrl>>/api/usuarios/token`  
Este endpoint proporciona un token JWT a los usuarios. Para acceder a él, es necesario enviar las credenciales en el encabezado de la solicitud codificadas en formato Base64

- **iniciar sesión**:  
    - **Nombre de usuario**: `webadmin`  
    - **Contraseña**: `admin`

## JUEGOS

## GET `<<BaseUrl>>/api/juegos`
Devuelve los juegos disponibles en la base datos, permitiendo aplicar filtros y ordenamiento de los resultados.

### ejemplo de uso

```
GET <<BaseUrl>>/api/juegos
```


### Query Params:

- **ORDENAMIENTO:**
  - `orderBy` : Campo por el que se desea ordenar los resultados. Los campos válidos incluyen:
    - `id_juegos`: ordena los juegos por ID.
    - `nombre`: Ordena los juegos por nombre.
    - `fecha_lanzamiento`: Ordena los juegos por fecha.
    - `precio`: Ordena los juegos por precio.

### ejemplo de ordenamiento

obtener todos los juegos ordenados por el nombre 
```
GET <<BaseUrl>>/api/juegos?orderBy=nombre
```

- **FILTRADO:**
 - `filterBy` : Campo por el que se desea filtrar los resultados. Los campos válidos incluyen:
    - `nombre`: Filtra los juegos por el nombre especificado (filtra los juegos cuyo nombre contiene el valor del filtro dado).
    - `precioigual`: Filtra los juegos cuyo precio sea el especificado.
    - `preciomenor`: Filtra los juegos cuyo precio sea menor al especificado.
    - `preciomayor`: Filtra los juegos cuyo precio sea mayor al especificado.
    - `preciomenorigual`: Filtra los juegos cuyo precio sea menor o igual al especificado.
    - `preciomayorigual`: Filtra los juegos cuyo precio sea mayor o igual al especificado.

- `filter` : Campo por el que se desea filtrar los resultados.

### ejemplo para filtrar

obtener todos los juegos con un precio igual a 59.99
```
GET <<BaseUrl>>/api/juegos?filterBy=precioigual&filter=59.99
```
obtener todos los juegos con un precio menor o igual a 120.36
```
GET <<BaseUrl>>/api/juegos?filterBy=preciomenorigual&filter=120.36
```
obtener todos los juegos cuyo nombre contengan league
```
GET <<BaseUrl>>/api/juegos?filterBy=nombre&filter=league
```

---

- **GET** `<<BaseUrl>>/api/juegos/:id`  
  Devuelve el juego correspondiente al `id` que solicitas.

---

- **POST** `<<BaseUrl>>/api/juegos`  
  Crea un nuevo juego con la información en formato JSON que se envia en el body. Para poder crear un nuevo juego e insertarlo en la base de datos, primero debe estar identificado a través de un token de autorización.

  - **Campos requeridos**:  
    - `nombre`
    - `fecha_lanzamiento`
    - `modalidad`
    - `plataformas`
    - `id_compania`
    - `precio`

    Ejemplo:
    ```
    {  
        "titulo": "league of legends",
        "fecha_lanzamiento": 23-11-2009,
        "modalidad":MOBA,
        "plataformas":windows, macOS,  
        "idcompania": 3,    
        "precio": 29.99  
    }
 	```

---


- **PUT** `<<BaseUrl>>/api/juegos/:id`  
  modifica el juego correspondiente al `id`.

---


- **DELETE** `<<BaseUrl>>/api/juegos/:id`  
  Elimina el juego que corresponda al `id`.para poder eliminar un juego, primero tenes que estar identificado por un token de autorizacion


---


## COMPANIAS

- **GET** `<<BaseUrl>>/api/companias`  
  trae las companias de la base de datos

---

- **GET** `<<BaseUrl>>/api/companias/:id`  
  trae la compania que corresponda al id

---

- **POST** `<<BaseUrl>>/api/companias`  
  Crea una nueva compania con la información en formato JSON que se pone en el body.
  
  ```
     {  
        "nombre": "blizzard",
        "fecha_fundacion":23-11-1989,
        "oficinas_centrales":los angeles,
        "sitio_web":blizzard.com  
     }  
  ```
---

- **PUT** `<<BaseUrl>>/api/companias/:id`  

  Modifica los datos de la compania correspondiente al `id`. La información a modificar se pone en formato JSON en el body

  
---

- **DELETE** `<<BaseUrl>>/api/companias/:id`  

  Elimina la compania correspondiente al `id`.

  
---


