<?php
include_once("Entidades/Token.php");
include_once("Entidades/Usuario.php");

class TokenApi extends Token{
    public function GenerarToken($request, $response, $args){
        $parametros = $request->getParsedBody();
        $user = $parametros["email"];
        $password  = $parametros["clave"];
       
        $usuario = Usuario::Login($user,$password)[0];
       //var_dump($usuario);
        //die();
        if($usuario->tipo_usuario != ""){
            $token = Token::CodificarToken($user,$usuario->tipo_usuario,$usuario->id);
            $respuesta = array("Estado" => "OK", "Mensaje" => "OK", "Token" => $token);
            
        }
        else{
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "Usuario o clave invalidos.");
        }
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    public function CrearUsuario($request, $response, $args){
        $parametros = $request->getParsedBody();
        $user = $parametros["email"];
        $password  = $parametros["clave"];
        $perfil = $parametros["perfil"];

        Usuario::Insertar($user,$password,$perfil);
        $respuesta = "Insertado Correctamente.";
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }
}