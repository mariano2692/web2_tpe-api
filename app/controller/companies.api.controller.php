<?php
require_once './app/model/companies.model.php';
require_once './app/view/json.view.php';
class CompanieApiController {
        private $companiesModel;
        private $view;
        private $auth;

        public function __construct(){
            $this->companiesModel = new CompaniesModel();
            $this->view = new JSONView();
            $this->auth = new AuthJWT();
        }

        public function getAll($req,$res){
            $filtro = new stdClass();

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

            switch($filtro->filterBy){
                case '':
                    $companies = $this->companiesModel->getCompanies();
                    return $this->view->response($companies);
                    break;
                case 'nombre':
                    $companies = $this->companiesModel->getCompaniesFilterByNombre($filtro->filter);
                    return $this->view->response($companies);
                    break;
                default:
                    $this->view->response('valor no valido',400);
                    break;
            }
        }

        public function getCompanie($req,$res){
                //obtengo el id
                $id = $req->params->id;

                $companie = $this->companiesModel->getCompanie($id);

                if(!$companie){
                    return $this->view->response("la compania con el id=$id no existe", 404);
                }

                return $this->view->response($companie);
            }
        
        
        
        public function create($req,$res){

            if(!$res->user){
                $this->view->response("no autorizado",401);
                return;
            }


            // valido los datos
            if (empty($req->body->nombre) || empty($req->body->fecha) ||  
            empty($req->body->oficinas) || empty($req->body->sitio_web)) {
            return $this->view->response('Faltan completar datos', 400);
            }

            // obtengo los datos
            $nombre = $req->body->nombre;       
            $fecha = $req->body->fecha;       
            $oficinas = $req->body->oficinas;
            $sitioweb = $req->body->sitio_web;   

            // inserto los datos
            $id = $this->companiesModel->addCompanie($nombre,$fecha,$oficinas,$sitioweb);

            if (!$id) {
            return $this->view->response("Error al insertar compania", 500);
            }

            $companie = $this->companiesModel->getCompanie($id);
            return $this->view->response($companie, 201);
        }

        public function update($req,$res){

            if(!$res->user){
                $this->view->response("no autorizado",401);
                return;
            }


            $id = $req->params->id;

            $companie = $this->companiesModel->getCompanie($id);

            if(!$companie){
                return $this->view->response("la compania con el id=$id no existe", 404);
            }

             // valido los datos
             if (empty($req->body->nombre) || empty($req->body->fecha) ||  
             empty($req->body->oficinas) || empty($req->body->sitio_web)) {
             return $this->view->response('Faltan completar datos', 400);
             }
             $nombre = $req->body->nombre;       
             $fecha = $req->body->fecha;       
             $oficinas = $req->body->oficinas;
             $sitioweb = $req->body->sitio_web;   

             $this->companiesModel->updateCompanie($id,$nombre,$fecha,$oficinas,$sitioweb);

             $companie = $this->companiesModel->getCompanie($id);
             return $this->view->response($companie,200);

        }

        public function delete($req,$res){
            if(!$res->user){
                $this->view->response("no autorizado",401);
                return;
            }

            $id = $req->params->id;
    
            $companie = $this->companiesModel->getCompanie($id);
    
            if (!$companie) {
                return $this->view->response("la compania con el id=$id no existe", 404);
            }
    
            $this->companiesModel->deleteCompanie($id);
            $this->view->response("la compania con el id=$id se eliminó con éxito");
        }

    }


?>