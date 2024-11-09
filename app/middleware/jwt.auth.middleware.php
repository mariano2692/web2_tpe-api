<?php
    class JWTAuthMiddleware {

        private $auth;

        public function __construct()
        {
            $this->auth = new AuthJWT();
        }

        public function run($req, $res) {
            $auth_header = $_SERVER['HTTP_AUTHORIZATION']; // "Bearer un.token.firma"
            $auth_header = explode(' ', $auth_header); // ["Bearer", "un.token.firma"]
            if(count($auth_header) != 2) {
                return;
            }
            if($auth_header[0] != 'Bearer') {
                return;
            }
            $jwt = $auth_header[1];
            $res->user = $this->auth->validateJWT($jwt);
        }
    }