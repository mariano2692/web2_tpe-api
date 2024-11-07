<?php
require_once './app/model/games.model.php';
require_once './app/view/json.view.php';
require_once './libs/jwt.php';

    class GamesApiController {
        private $model;
        private $view;

        public function __construct(){
            $this->model = new gamesModel();
            $this->view = new JSONView();
        }

        public function getAllGames($req,$res){

            // $user = currentUser();
            // if(!$user){
            //     $this->view->response("no autorizado",401);
            //     return;
            // }

            $games = [];

            $filtrarPlataforma = false;

            if(isset($req->query->plataforma)){
                $filtrarPlataforma = $req->query->plataforma;
            }
            

            $orderBy = false;
            if(isset($req->query->orderBy)){
                $orderBy = $req->query->orderBy;
            }

            $games = $this->model->getGames($orderBy,$filtrarPlataforma);

            return $this->view->response($games);
        }

        public function getGame($req,$res){
            $id = $req->params->id;

            $game = $this->model->getGame($id);

            if(!$game){
                return $this->view->response("el juego con el id=$id no existe", 404);
            }

            return $this->view->response($game);
        }

        public function delete($req, $res) {
            $id = $req->params->id;
    
            $game = $this->model->getGame($id);
    
            if (!$game) {
                return $this->view->response("el juego con el id=$id no existe", 404);
            }
    
            $this->model->deleteGame($id);
            $this->view->response("el juego con el id=$id se eliminó con éxito");
        }


        public function create($req, $res) {

            // valido los datos
            if (empty($req->body->nombre) || empty($req->body->fecha) || empty($req->body->modalidad) || 
                empty($req->body->plataformas) || empty($req->body->id_compania)) {
                return $this->view->response('Faltan completar datos', 400);
            }
    
            // obtengo los datos
            $nombre = $req->body->nombre;       
            $fecha = $req->body->fecha;       
            $modalidad = $req->body->modalidad;
            $plataformas = $req->body->plataformas;
            $id_compania = $req->body->id_compania;       
    
            // inserto los datos
            $id = $this->model->addGame($nombre,$fecha,$modalidad,$plataformas,$id_compania,0);
    
            if (!$id) {
                return $this->view->response("Error al insertar tarea", 500);
            }
    
            // buena práctica es devolver el recurso insertado
            $game = $this->model->getGame($id);
            return $this->view->response($game, 201);
        }

        public function update($req, $res) {
            $id = $req->params->id;
    
            // verifico que exista
            $game = $this->model->getGame($id);
            if (!$game) {
                return $this->view->response("el juego con el id=$id no existe", 404);
            }
    
             // valido los datos
             if (empty($req->body->nombre) || empty($req->body->fecha) || empty($req->body->modalidad) || empty($req->body->plataformas)||
              empty($req->body->id_compania)) {
                return $this->view->response('Faltan completar datos', 400);
            }
    
            // obtengo los datos
            $nombre = $req->body->nombre;       
            $fecha = $req->body->fecha;       
            $modalidad = $req->body->modalidad;
            $plataformas = $req->body->plataformas;
            $id_compania = $req->body->id_compania;
    
            // actualizo el juego
            $this->model->addGame($nombre, $fecha, $modalidad, $plataformas,$id_compania,$id);
    
            // obtengo el juego que modifique y lo devuelvo
            $game = $this->model->getGame($id);
            $this->view->response($game, 200);
        }
    
    
    
    
    
    }