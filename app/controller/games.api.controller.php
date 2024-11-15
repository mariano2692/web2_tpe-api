<?php
require_once './app/model/games.model.php';
require_once './app/model/companies.model.php';
require_once './app/model/review.model.php';
require_once './app/view/json.view.php';
require_once './libs/jwt.php';

    class GamesApiController {
        private $gamesModel;
        private $companiesModel;
        private $reviewModel;
        private $view;
        private $auth;

        public function __construct(){
            $this->gamesModel = new gamesModel();
            $this->companiesModel = new CompaniesModel();
            $this->reviewModel = new ReviewModel();
            $this->view = new JSONView();
            $this->auth = new AuthJWT();
        }

        public function getAllGames($req,$res){

            // $user = $this->auth->currentUser();
            // if(!$user){
            //     $this->view->response("no autorizado",401);
            //     return;
            // }

            $games = [];

            //FILTRAR POR COMPANIA

            $filtrarCompania = null;

            if(isset($req->query->compania)){
                //BUSCO EL ID DE LA COMPANIA POR EL NOMBRE;
                $companiaObj = $this->companiesModel->getCompaniaNombre($req->query->compania);
                $filtrarCompania = $companiaObj->id_compania;
            }


            //FILTRAR POR PRECIO MENOR 
            $filtrarPrecio = null;
            //FILTRAR POR NOMBRE
            $filtrarNombre = null;

            if(isset($req->query->precio)){
                $filtrarPrecio = $req->query->precio;
            }

            if(isset($req->query->nombre)){
                $filtrarNombre = $req->query->nombre;
            }
            
            // ORDENAR POR FECHA, NOMBRE, PRECIO

            $orderBy = false;
            if(isset($req->query->orderBy)){
                $orderBy = $req->query->orderBy;
            }

            $games = $this->gamesModel->getGames($orderBy,$filtrarPrecio,$filtrarNombre,$filtrarCompania);

            foreach ($games as $game) {
        
                //AGREGO LAS DATOS DE LA COMPANIA QUE LE CORRESPONDE A CADA JUEGO
                $game->compania = $this->companiesModel->getCompania($game->id_compania);
                //ARRAY DE COMENTARIOS QUE CORRESPONDEN A CADA JUEGO
                $game->resenias = $this->reviewModel->getReviewByGame($game->id_juegos);
            }

            return $this->view->response($games);
        }

        public function getGame($req,$res){


            $user = $this->auth->currentUser();
            if(!$user){
                $this->view->response("no autorizado",401);
                return;
            }

            $id = $req->params->id;

            $game = $this->gamesModel->getGame($id);

            if(!$game){
                return $this->view->response("el juego con el id=$id no existe", 404);
            }

            return $this->view->response($game);
        }

        public function delete($req, $res) {

            $user = $this->auth->currentUser();
            if(!$user){
                $this->view->response("no autorizado",401);
                return;
            }

            if(!$user->rol != 'administrador'){
                $this->view->response("prohibido",403);
            }

            $id = $req->params->id;
    
            $game = $this->gamesModel->getGame($id);
    
            if (!$game) {
                return $this->view->response("el juego con el id=$id no existe", 404);
            }
    
            $this->gamesModel->deleteGame($id);
            $this->view->response("el juego con el id=$id se eliminó con éxito");
        }


        public function create($req, $res) {

            $user = $this->auth->currentUser();
            if(!$user){
                $this->view->response("no autorizado",401);
                return;
            }

            if(!$user->rol != 'administrador'){
                $this->view->response("prohibido",403);
            }

            // valido los datos
            if (empty($req->body->nombre) || empty($req->body->fecha) || empty($req->body->modalidad) || 
                empty($req->body->plataformas) || empty($req->body->id_compania) || empty($req->body->precio)) {
                return $this->view->response('Faltan completar datos', 400);
            }
    
            // obtengo los datos
            $nombre = $req->body->nombre;       
            $fecha = $req->body->fecha;       
            $modalidad = $req->body->modalidad;
            $plataformas = $req->body->plataformas;
            $id_compania = $req->body->id_compania;
            $precio = $req->body->precio;       
    
            // inserto los datos
            $id = $this->gamesModel->addGame($nombre,$fecha,$modalidad,$plataformas,$id_compania,$precio,0);
    
            if (!$id) {
                return $this->view->response("Error al insertar juego", 500);
            }
    
            $game = $this->gamesModel->getGame($id);
            return $this->view->response($game, 201);
        }

        public function update($req, $res) {


            $user = $this->auth->currentUser();
            if(!$user){
                $this->view->response("no autorizado",401);
                return;
            }

            if(!$user->rol != 'administrador'){
                $this->view->response("prohibido",403);
            }

            $id = $req->params->id;
    
            // verifico que exista
            $game = $this->gamesModel->getGame($id);
            if (!$game) {
                return $this->view->response("el juego con el id=$id no existe", 404);
            }
    
             // valido los datos
             if (empty($req->body->nombre) || empty($req->body->fecha) || empty($req->body->modalidad) || empty($req->body->plataformas)||
              empty($req->body->id_compania) || empty($req->body->precio)) {
                return $this->view->response('Faltan completar datos', 400);
            }
    
            // obtengo los datos
            $nombre = $req->body->nombre;       
            $fecha = $req->body->fecha;       
            $modalidad = $req->body->modalidad;
            $plataformas = $req->body->plataformas;
            $id_compania = $req->body->id_compania;
            $precio = $req->body->precio;   

    
            // actualizo el juego
            $this->gamesModel->addGame($nombre, $fecha, $modalidad, $plataformas,$id_compania,$precio,$id);
    
            // obtengo el juego que modifique y lo devuelvo
            $game = $this->gamesModel->getGame($id);
            $this->view->response($game, 200);
        }
    
    }