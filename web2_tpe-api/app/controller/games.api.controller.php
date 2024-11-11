<?php
require_once 'C:/xampp/htdocs/web2_tpe-api/app/model/games.model.php';
require_once 'C:/xampp/htdocs/web2_tpe-api/app/view/json.view.php';
require_once 'C:/xampp/htdocs/web2_tpe-api/libs/jwt.php';

class GamesApiController {
    private $model;
    private $view;
    private $auth;

    public function __construct(){
        $this->model = new gamesModel();
        $this->view = new JSONView();
        $this->auth = new AuthJWT();
    }

    public function getAllGames($req, $res) {
        // Verificar autenticación del usuario
        $user = $this->auth->currentUser();
        if (!$user) {
            $this->view->response("no autorizado", 401);
            return;
        }

        // Parámetros de paginación
        
        // Página por defecto
        $page = isset($req->query->page) ? (int)$req->query->page : 1;  
        // Límite de paginas por defecto
        $limit = isset($req->query->limit) ? (int)$req->query->limit : 10;  
        // Calcular el punto a partir de donde se van a mostrar los juegos
        $puntoDeInicio = ($page - 1) * $limit;  

        // Filtro de precio
        $filtrarPrecio = null;
        if (isset($req->query->precio)) {
            $filtrarPrecio = $req->query->precio;
        }

        // Ordenar resultados
        $orderBy = false;
        if (isset($req->query->orderBy)) {
            $orderBy = $req->query->orderBy;
        }

        // Obtener los juegos con paginación y filtros
        $games = $this->model->getGames($orderBy, $filtrarPrecio, $limit, $puntoDeInicio);

        // Obtener el número total de juegos para la paginación
        $totalGames = $this->model->countGames($filtrarPrecio);
        $totalPages = ceil($totalGames / $limit);

        // Obtener información adicional para cada juego (compañía)
        foreach ($games as $game) {
            $game->compania = $this->model->getCompania($game->id_compania);
        }

        // Responder con los juegos, página actual y total de páginas
        return $this->view->response([
            'data' => $games,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function getGame($req, $res) {
        $user = $this->auth->currentUser();
        if(!$user){
            $this->view->response("no autorizado",401);
            return;
        }

        $id = $req->params->id;
        $game = $this->model->getGame($id);

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
        $game = $this->model->getGame($id);

        if (!$game) {
            return $this->view->response("el juego con el id=$id no existe", 404);
        }

        $this->model->deleteGame($id);
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
        $id = $this->model->addGame($nombre,$fecha,$modalidad,$plataformas,$id_compania,$precio,0);

        if (!$id) {
            return $this->view->response("Error al insertar juego", 500);
        }

        $game = $this->model->getGame($id);
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
        $game = $this->model->getGame($id);
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
        $this->model->addGame($nombre, $fecha, $modalidad, $plataformas,$id_compania,$precio,$id);

        // obtengo el juego que modifique y lo devuelvo
        $game = $this->model->getGame($id);
        $this->view->response($game, 200);
    }
    }