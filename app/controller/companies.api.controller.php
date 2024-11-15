<?php

class GamesApiController {
    private $companiesModel;
    private $view;
    private $auth;

    public function __construct(){
        $this->companiesModel = new CompaniesModel();
        $this->view = new JSONView();
        $this->auth = new AuthJWT();
    }

    public function getAll($req,$res){

    }
}

?>