<?php
require_once 'app/model/model.php';

class CompaniesModel extends Model {

    public function getCompanies(){
        $sql = 'SELECT * FROM compania';
        $query = $this->db->prepare($sql);
        $query->execute();

        $companias = $query->fetchAll(PDO::FETCH_OBJ);
        return $companias;
    }


    public function getCompanie($id){
        $query = $this->db->prepare('SELECT * FROM compania WHERE id_compania = ?');
        $query->execute([$id]);
        $compania = $query->fetch(PDO::FETCH_OBJ);
        return $compania;
    }

    public function getCompanieFilterBy($columnLike, $filter){
        if (strpos($columnLike, 'LIKE') !== false) {
            $filter = "%$filter%"; // Agregar comodines al inicio y al final
        }
        $query = $this->db->prepare("SELECT * FROM compania WHERE $columnLike ?");
        $query->bindValue(1, $filter);
        $query->execute();
        $companias = $query->fetchAll(PDO::FETCH_OBJ);
        return $companias;
    }

    public function getCompaniesFilterByNombre($filter){
        return $this->getCompanieFilterBy("nombre LIKE ", $filter);
    }

    public function addCompanie($nombre,$fecha,$oficinas,$sitioweb){
        $query = $this->db->prepare('INSERT INTO companias(nombre, fecha_fundacion, oficinas_centrales, sitio_web) VALUES (?, ?, ?, ?)');
        $query->execute([$nombre,$fecha,$oficinas,$sitioweb]);
        $id = $this->db->lastInsertId();
        return $id;
    }

    public function updateCompanie($id,$nombre,$fecha,$oficinas,$sitioweb){
        $query = $this->db->prepare('UPDATE companias SET nombre = ?, fecha_fundacion = ?, oficinas_centrales = ?, sitio_web = ? WHERE id_compania = ?');
        $query->execute([$nombre,$fecha,$oficinas,$sitioweb,$id]);
    }
   
}

?>