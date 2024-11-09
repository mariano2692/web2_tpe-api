<?php

require_once './app/model/review.model.php';
require_once './app/view/json.view.php';

    class ReviewApiController{
        private $model;
        private $view;
        public function __construct()
        {
            $this->model = new ReviewModel();
            $this->view = new JSONView();
        }

        public function getAll($req,$res){

            $resenias = $this->model->getAll();

            $this->view->response($resenias);
        }

    }

?>