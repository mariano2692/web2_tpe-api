# Lista de Juegos

## Integrantes:
* mariano alberto menendez
* teo ivan blas garcia


## Descripción:
Esta es una descripción adaptada para una aplicación de gestión de Juegos y Compañías con una relación 1 a N:

La aplicación maneja una base de datos de juegos, compañías de dichos juegos, con relacion 1 a N: entre Compañías y Juegos. Además, incluye una tabla de usuarios para gestionar los accesos mediante login.

La aplicación permite mostrar los datos de los juegos. En la tabla donde se listan los juegos, aparecen íconos de Edición y Borrado junto a cada uno de ellos, pero solo se muestran si un usuario ha iniciado sesión correctamente. Al pulsar en el ícono de edición, se puede modificar directamente los datos del juego, como el título, fecha de lanzamiento, y seleccionar el género y la compañía de una lista disponible en la base de datos.

Finalmente, se incluye un botón para añadir nuevos juegos, que solo está visible cuando un usuario ha iniciado sesión, y redirige a un formulario para dar de alta nuevos juegos.

Al hacer click en el menú Compañías, se visualiza una lista de las compañías de videojuegos, junto con los datos de cada una. Si se selecciona una compañía en particular, se muestran los datos correspondientes.

El funcionamiento de la Edición, Borrado, Alta de nuevas compañías sigue un esquema similar al aplicado para la lista de juegos. Al intentar eliminar una compañía, el sistema verifica que no tenga juegos asociados; si los tiene, no permite su eliminación hasta que dichos juegos sean borrados o asignados a otra compañía.

* Se incluye la opción de Config.php y AutoDeploy.
* Todo el sistema usa el patrón MVC.
* Las url son semánticas.
* Se incluye el SQL para la instalación de la base de datos
* Se incluye un usario "webadmin" con clave "admin"

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