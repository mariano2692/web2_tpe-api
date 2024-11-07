<?php

require_once 'app/model/model.php';

class userModel extends Model{

    public function getUser($userdb){
        $query = $this->db->prepare("SELECT * FROM usuario WHERE usuario = ?");
        $query->execute(array($userdb));

        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;

    }
}
?>