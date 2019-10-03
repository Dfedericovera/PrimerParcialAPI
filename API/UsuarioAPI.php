<?php

include_once("Entidades/Usuario.php");


class UsuarioAPI extends Usuario{
    public function TraerTodos($request, $response, $args){
        $todos = Usuario::ConsultarTodos();
        $newResponse = $response->withJson($todos, 200);
        return $newResponse;
    }

    
}

    ?>