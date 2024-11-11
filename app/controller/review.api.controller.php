<?php
require_once './app/model/games.model.php';
require_once './app/model/companies.model.php';
require_once './app/model/review.model.php';
require_once './app/view/json.view.php';

    class ReviewApiController{
        private $reviewModel;
        private $gamesModel;
        private $companiesModel;
        private $userModel;
        private $view;
        public function __construct()
        {
            $this->userModel = new userModel();
            $this->reviewModel = new reviewModel();
            $this->gamesModel = new gamesModel();
            $this->companiesModel = new CompaniesModel();
            $this->view = new JSONView();
        }

        public function getAll($req,$res){

            $resenias = $this->reviewModel->getAll();

            $this->view->response($resenias);
        }

    }

?>