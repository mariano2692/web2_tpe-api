<?php
require_once 'app/model/model.php';

class ReviewModel extends Model {

    public function getAll(){
        $sql = 'SELECT * FROM resenias';
        $query = $this->db->prepare($sql);
        $query->execute();

        $resenias = $query->fetchAll(PDO::FETCH_OBJ);
        return $resenias;
    }

    public function getReviewById($id){
        $sql = 'SELECT * FROM resenias WHERE id_resenia = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$id]);

        $resenia = $query->fetch(PDO::FETCH_OBJ);
        return $resenia;
    }

    public function getReviewByGame($id_juego){
        $sql = 'SELECT * FROM resenias WHERE id_juego = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$id_juego]);

        $resenias = $query->fetchAll(PDO::FETCH_OBJ);
        return $resenias;
    }

    public function insertResenia($id_juego,$id_usuario,$titulo,$comentario){
        $sql = 'INSERT INTO resenias (id_juego, id_usuario, titulo, comentario) VALUES (?, ?, ?, ?)';
        $query = $this->db->prepare($sql);
        $query->execute([$id_juego,$id_usuario,$titulo,$comentario]);

    }
   
}

?>