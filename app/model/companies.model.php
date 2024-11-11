<?php
require_once 'app/model/model.php';

class CompaniesModel extends Model {

    public function getAll(){
        $sql = 'SELECT * FROM companias';
        $query = $this->db->prepare($sql);
        $query->execute();

        $companias = $query->fetchAll(PDO::FETCH_OBJ);
        return $companias;
    }


    public function getCompania($id){
        $query = $this->db->prepare('SELECT * FROM compania WHERE id_compania = ?');
        $query->execute([$id]);
        $compania = $query->fetch(PDO::FETCH_OBJ);
        return $compania;
    }

    public function getCompaniaNombre($name){
        $query = $this->db->prepare('SELECT id_compania FROM compania WHERE nombre = ?');
        $query->execute([$name]);
        $compania = $query->fetch(PDO::FETCH_OBJ);
        return $compania;
    }

    public function addCompanie($nombre,$fecha,$oficinas,$sitioweb){
        $query = $this->db->prepare('INSERT INTO companias(nombre, fecha_fundacion, oficinas_centrales, sitio_web) VALUES (?, ?, ?, ?)');
        $query->execute([$nombre,$fecha,$oficinas,$sitioweb]);
        $id = $this->db->lastInsertId();
        return $id;
    }

    public function editeCompanie($id,$nombre,$fecha,$oficinas,$sitioweb){
        $query = $this->db->prepare('UPDATE companias SET nombre = ?, fecha_fundacion = ?, oficinas_centrales = ?, sitio_web = ? WHERE id_compania = ?');
        $query->execute([$nombre,$fecha,$oficinas,$sitioweb,$id]);
    }
   
}

?>