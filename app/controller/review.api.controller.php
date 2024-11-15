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

            $reviews = $this->reviewModel->getAll();

            $this->view->response($reviews);
        }

        public function getReview($req,$res){
            $id = $req->params->id;

            $review = $this->reviewModel->getReviewById($id);
            
            if(!$review){
                return $this->view->response("la reseña con el id $id no existe",404);
            }

            $this->view->response($review);

        }

        public function createReview($req,$res){


            if (empty($req->body->id_usuario) || empty($req->body->id_juego) ||
                empty($req->body->titulo) || empty($req->body->comentario)) {
                     return $this->view->response('Faltan completar datos', 400);
            }

            $id_usuario = $req->body->id_usuario;
            $id_juego = $req->body->id_juego;
            $titulo = $req->body->titulo;
            $comentario = $req->body->comentario;

        }

    }

?>