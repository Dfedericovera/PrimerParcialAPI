<?php
include_once("Entidades/Actor.php");

class ActorAPI extends Actor{

   
    public function TraerTodos($request, $response, $args){
        $todos = Actor::ConsultarTodos();
        $newResponse = $response->withJson($todos, 200);
        return $newResponse;
    }

    public function Cargar($request, $response, $args){
        $json = $request->getBody();
        /* $data = json_decode($json, true); */
        $parametros=json_decode($json, true);
       /*  $parametros = $request->getParsedBody(); */
        //$files = $request->getUploadedFiles();
        /* $payload = $request->getAttribute("payload")["Payload"];
        $usuario=$payload->user; */
        $nombre = $parametros["nombre"];
        $apellido = $parametros["apellido"];
        $nacionalidad = $parametros["nacionalidad"];
        $fechaDeNacimiento = $parametros["fecha_de_nacimiento"];     

            $respuesta = "Insertado Correctamente.";
            Actor::Insertar($nombre,$apellido,$nacionalidad,$fechaDeNacimiento);
            $newResponse = $response->withJson($respuesta,200);
            return $newResponse;
        
     
    }


     public function CargarConImagen($request, $response, $args){
        
         $payload = $request->getAttribute("payload")["Payload"];
         $usuario=$payload->user;

        $parametros = $request->getParsedBody();
        $files = $request->getUploadedFiles();
        $articulo = $parametros["articulo"];
        $precio = $parametros["precio"];
        $fecha = $parametros["fecha"];
        $foto = $files["foto"];
 
        //Consigo la extensión de la foto.  
        $ext = Foto::ObtenerExtension($foto);
        if($ext != "ERROR"){
            //Genero el nombre de la foto.
            $nombreFoto = $articulo."_Foto".$ext;  

            //Guardo la foto.
            $rutaFoto = "./IMGCompras/".$nombreFoto;
            Foto::GuardarFoto($foto,$rutaFoto);
    
            $respuesta = "Insertado Correctamente.";
            Compra::Insertar($articulo,$precio,$fecha,$usuario,$nombreFoto);
            $newResponse = $response->withJson($respuesta,200);
            return $newResponse;
        }
        else{
            $respuesta = "Ocurrio un error.";
            $newResponse = $response->withJson($respuesta,200);
            return $newResponse;
        }        

}
}



?>