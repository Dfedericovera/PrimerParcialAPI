<?php
include_once("Entidades/Pelicula.php");

class PeliculaAPI extends Pelicula{



   
    public function TraerTodos($request, $response, $args){
        $todos = Pelicula::ConsultarTodos();
        $newResponse = $response->withJson($todos, 200);
        return $newResponse;
    }

    public function Cargar($request, $response, $args){
        /* $parametros = $request->getParsedBody();
        //$files = $request->getUploadedFiles();
        $payload = $request->getAttribute("payload")["Payload"];
        $usuario=$payload->user; */
        $json = $request->getBody();
        /* $data = json_decode($json, true); */
        $parametros=json_decode($json, true);
        $nombre = $parametros["nombre"];
        $genero = $parametros["genero"];
        $fecha_de_estreno = $parametros["fecha_de_estreno"];
        $cantidadDePublico = $parametros["cantidadDePublico"];     

            $respuesta = "Insertado Correctamente.";
            Pelicula::Insertar($nombre,$genero,$fecha_de_estreno,$cantidadDePublico);
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