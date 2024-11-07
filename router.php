<?php
    
    require_once 'libs/router.php';

    require_once 'app/controller/games.api.controller.php';
    require_once 'app/controller/user.api.controller.php';
    require_once 'app/middleware/jwt.auth.middleware.php';
    $router = new Router();

    $router->addMiddleware(new JWTAuthMiddleware());

    #                 endpoint        verbo      controller              metodo
    $router->addRoute('juegos'      ,            'GET',     'GamesApiController',   'getAllGames');
    $router->addRoute('juegos/:id'  ,            'GET',     'GamesApiController',   'getGame'   );
    $router->addRoute('juegos/:id'  ,            'DELETE',  'GamesApiController',    'delete');
    $router->addRoute('juegos'  ,                'POST',    'GamesApiController',    'create');
    $router->addRoute('juegos/:id'  ,            'PUT',     'GamesApiController',    'update');
    // $router->addRoute('tareas/:id/finalizada'  , 'PUT',     'TaskApiController',   'setFinalize');
    
    $router->addRoute('usuarios/token'    ,            'GET',     'UserApiController',   'getToken');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);