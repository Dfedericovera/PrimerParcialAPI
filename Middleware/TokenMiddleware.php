<?php
    class TokenMiddleware{
        public static function ValidarToken($request,$response,$next){
            $token = $request->getHeader("token");
            $validacionToken = Token::DecodificarToken($token[0]);
            if($validacionToken["Estado"] == "OK"){
                $request = $request->withAttribute("payload", $validacionToken);
                return $next($request,$response);
            }
            else{
                $newResponse = $response->withJson($validacionToken,200);
                return $newResponse;
            }
        }

        public static function ValidarAdmin($request,$response,$next){
            $payload = $request->getAttribute("payload")["Payload"];

            if($payload->tipoUser == "admin"){
                return $next($request,$response);
            }
            else{
                $newResponse = $response->withJson("hola",200);
                return $newResponse;
            }
        }

        public static function ValidarUsuario($request,$response,$next){
            $payload = $request->getAttribute("payload")["Payload"];
            if($payload->tipoUser == "usuario"){
                return $next($request,$response);
            }
            else{
                $newResponse = $response->withJson("ERROR: No tienes permiso para realizar esta accion (Solo categoria usuario).",200);
                return $newResponse;
            }
        }
    }
?>