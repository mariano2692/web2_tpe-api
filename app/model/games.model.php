<?php

require_once 'app/model/model.php';


    class gamesModel extends Model {
   
        public function getGames($orderBy = false,$filtrarPrecio = null, $filtrarNombre = null, $filtrarCompania = null){
            $sql = 'SELECT * FROM juegos';
            $params = [];

            if($filtrarPrecio){
                $sql.= ' WHERE precio < ?';
                $params[] = $filtrarPrecio;
            }

            if($filtrarNombre){
                $sql.= ' WHERE nombre = ?';
                $params[] = $filtrarNombre;
            }

            if($filtrarCompania){
                $sql.= ' WHERE id_compania = ?';
                $params[] = $filtrarCompania;
            }

            if($orderBy){
                switch($orderBy){
                    case 'fecha':
                        $sql.= ' ORDER BY fecha_lanzamiento';
                        break;
                    case 'nombre':
                        $sql.= ' ORDER BY nombre';
                        break;
                    case 'precio':
                        $sql.= ' ORDER BY precio DESC';
                }
            }
            $query = $this->db->prepare($sql);
            $query->execute($params);

            $juegos = $query->fetchAll(PDO::FETCH_OBJ);
            return $juegos;
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