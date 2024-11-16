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

        //////////////////////////////////////GET ALL GAMES//////////////////////////////////////////////////////////////////////////
        // /api/juegos (GET)
        public function getAllGames($req,$res){

            // $user = $this->auth->currentUser();
            // if(!$user){
            //     $this->view->response("no autorizado",401);
            //     return;
            // }


            $filtro = new stdClass();
            //verificar si hay un orden
            if(isset($req->query->orderBy)){
                $filtro->order = $req->query->orderBy;
            }
            else{
                $filtro->order = '';
            }
            //verificar si hay un filtro
            if(isset($req->query->filterBy)){
                $filtro->filterBy = $req->query->filterBy;
            }
            else{
                $filtro->filterBy = '';
            }
            //verificar el valor por el que se quiere filtrar
            if(isset($req->query->filter)){
                $filtro->filter = $req->query->filter;
            }
            else{
                $filtro->filter = '';
            }

            //usar el filtro
            switch($filtro->filterBy){
                case '':
                    $games = $this->gamesModel->getGames($filtro->order);
                    return $this->view->response($games);
                    break;
                case 'nombre':
                    $games = $this->gamesModel->getGamesFilterByNombre($filtro->filter,$filtro->order);
                    return $this->view->response($games);
                    break;
                case 'precioigual':
                    $games = $this->gamesModel->getGamesFilterByPrecioIgual($filtro->filter,$filtro->order);
                    return $this->view->response($games);
                    break;
                case 'preciomenorigual':
                    $games = $this->gamesModel->getGamesFilterByPrecioMenorIgual($filtro->filter,$filtro->order);
                    return $this->view->response($games);
                    break;
                case 'preciomenor':
                    $games = $this->gamesModel->getGamesFilterByPrecioMenor($filtro->filter,$filtro->order);
                    return $this->view->response($games);
                    break;
                case 'preciomayorigual':
                    $games = $this->gamesModel->getGamesFilterByPrecioMayorIgual($filtro->filter,$filtro->order);
                    return $this->view->response($games);
                    break;
                case 'preciomayor':
                    $games = $this->gamesModel->getGamesFilterByPrecioMayor($filtro->filter,$filtro->order);
                    return $this->view->response($games);
                    break;
                default:
                    $this->view->response('valor no válido', 400);
                    break;
            }


        }

        ///////////////////////////////////////////GET GAME////////////////////////////////////////////////////////////////////////
        // /api/juegos/:id  (GET)
        public function getGame($req,$res){


            $user = $this->auth->currentUser();
            if(!$user){
                $this->view->response("no autorizado",401);
                return;
            }

            //obtengo el id
            $id = $req->params->id;

            $game = $this->gamesModel->getGame($id);

            if(!$game){
                return $this->view->response("el juego con el id=$id no existe", 404);
            }

            return $this->view->response($game);
        }

        ////////////////////////////////////////////DELETE/////////////////////////////////////////////////////////////////////////////
        // /api/juegos/:id (DELETE)
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

        ////////////////////////////////////////////////////////POST///////////////////////////////////////////////////////////////////////
        // /api/juegos (POST)

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

        ///////////////////////////////////////////////////UPDATE///////////////////////////////////////////////////////////////////////
        // /api/juegos/:id (PUT)

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