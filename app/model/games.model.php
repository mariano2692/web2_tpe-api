<?php

require_once 'app/model/model.php';


    class gamesModel extends Model {

   
        public function getGames($order='id_juegos'){
            $validColumns = ['id_juegos', 'nombre', 'fecha_lanzamiento', 'modalidad', 'plataformas', 'precio'];

            // Validar que $order sea una columna válida, si no, usar la columna por defecto
            if (!in_array($order, $validColumns)) {
            $order = 'id_juegos';
            }
            $sql = "SELECT id_juegos, juegos.nombre, fecha_lanzamiento, modalidad, plataformas, juegos.id_compania, compania.nombre as nombre_compania, precio FROM juegos, compania 
                    WHERE juegos.id_compania = compania.id_compania ORDER BY $order";
            $query = $this->db->prepare($sql);
            $query->execute();
            $games = $query->fetchAll(PDO::FETCH_OBJ);
            return $games;

        }


        public function getGameFilterBy($columnLike, $filter, $order = 'id_juegos'){
            $allowedColumns = [
                'juegos.nombre LIKE ',
                'precio = ',
                'precio <= ',
                'precio >= ',
                'precio < ',
                'precio > '
            ];
            $allowedOrderColumns = ['id_juegos', 'juegos.nombre', 'fecha_lanzamiento', 'modalidad'];
            
            if (!in_array($columnLike, $allowedColumns)) {
                throw new Exception("Parámetro de columna no válido");
            }
            if (empty($order) || !in_array($order, $allowedOrderColumns)) {
                $order = 'id_juegos'; // Valor predeterminado si $order es vacío o no válido
            }

            if (strpos($columnLike, 'LIKE') !== false) {
                $filter = "%$filter%"; // Agregar comodines al inicio y al final
            }

            $sql = "SELECT 
            id_juegos, 
            juegos.nombre, 
            fecha_lanzamiento, 
            modalidad, 
            plataformas,
            precio, 
            juegos.id_compania, 
            compania.nombre AS nombre_compania
            FROM juegos
            INNER JOIN compania ON juegos.id_compania = compania.id_compania
            WHERE $columnLike ?
            ORDER BY $order";

        // Preparar y ejecutar la consulta
        $query = $this->db->prepare($sql);
        $query->execute([$filter]);

        return $query->fetchAll(PDO::FETCH_OBJ);

        }

        public function getGamesFilterByNombre($filter, $order = 'id_juegos'){
            return $this->getGameFilterBy("juegos.nombre LIKE " ,$filter , $order);
        }

        public function getGamesFilterByPrecioIgual($filter, $order = 'id_juegos'){
            return $this->getGameFilterBy("precio = ",$filter, $order);
        }
        public function getGamesFilterByPrecioMenorIgual($filter, $order = 'id_juegos'){
            return $this->getGameFilterBy("precio <= ",$filter, $order);
        }
        public function getGamesFilterByPrecioMayorIgual($filter, $order = 'id_juegos'){
            return $this->getGameFilterBy("precio >= ",$filter, $order);
        }
        public function getGamesFilterByPrecioMenor($filter, $order = 'id_juegos'){
            return $this->getGameFilterBy("precio < ",$filter, $order);
        }
        public function getGamesFilterByPrecioMayor($filter, $order = 'id_juegos'){
            return $this->getGameFilterBy("precio > ",$filter, $order);
        }

        public function getGame($id){
            $query = $this->db->prepare('SELECT * FROM juegos WHERE id_juegos = ?');
            $query->execute(array($id));

            $juego = $query->fetch(PDO::FETCH_OBJ);
            return $juego;
        }

        //reutilizo el metodo addGame, si no viene un id, estoy agregando un juego nuevo, si viene un id estoy modificando un juego existente

        public function addGame($nombre,$fecha,$modalidad,$plataforma,$id_compania,$precio,$id){
            try {
                if ($id == 0) {
                    $query = $this->db->prepare('INSERT INTO juegos(nombre, fecha_lanzamiento, modalidad, plataformas, id_compania, precio) VALUES(?, ?, ?, ?, ?, ?)');
                    $query->execute(array($nombre, $fecha, $modalidad, $plataforma, $id_compania, $precio));
                    $id = $this->db->lastInsertId();
                    return $id;
                } else {
                    $query = $this->db->prepare("UPDATE juegos SET nombre = ?, fecha_lanzamiento = ?, modalidad = ?, plataformas = ?, id_compania = ?, precio = ? WHERE id_juegos = ?");
                    $query->execute(array($nombre, $fecha, $modalidad, $plataforma, $id_compania, $precio, $id));
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage(); // Muestra el mensaje de error
            }
            
        }

        public function deleteGame($id){
            $query = $this->db->prepare('DELETE FROM juegos WHERE id_juegos = ?');
            $query->execute(array($id));
        }
        
    }