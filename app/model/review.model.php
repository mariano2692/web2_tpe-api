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

    public function getReviewByUser(){
        
    }
   
}

?>