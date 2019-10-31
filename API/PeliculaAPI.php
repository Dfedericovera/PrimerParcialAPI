<?php

use Slim\Http\UploadedFile;

include_once("Entidades/Pelicula.php");
include_once("Entidades/Foto.php");
class PeliculaAPI extends Pelicula{

   
    public function Eliminar($request, $response, $args){

        $json = $request->getBody();
        /* $data = json_decode($json, true); */
        $parametros=json_decode($json, true);
        $id = $parametros["id"];

            $respuesta = "Eliminado Correctamente.";
            Pelicula::EliminarPelicula($id);
            $newResponse = $response->withJson($respuesta,200);
            return $newResponse;
    }

   
    public function TraerTodos($request, $response, $args){
        $todos = Pelicula::ConsultarTodos();
        $newResponse = $response->withJson($todos, 200);
        return $newResponse;
    }
    public function Foto($request, $response, $args){
        $files = $request->getUploadedFiles();
        $foto = $files["file"];
        var_dump($foto);
        
    }

    public function Cargar($request, $response, $args){
        /* $parametros = $request->getParsedBody();
        //$files = $request->getUploadedFiles();
        $payload = $request->getAttribute("payload")["Payload"];
        $usuario=$payload->user; */
        $json = $request->getBody();
        $parametros=json_decode($json, true);
        $nombre = $parametros["nombre"];
        $genero = $parametros["genero"];
        $fecha_de_estreno = $parametros["fecha_de_estreno"];
        $cantidadDePublico = $parametros["cantidadDePublico"];
        $files = $request->getUploadedFiles();
        var_dump($files["foto"]);
        /* $uploadedFile = new UploadedFile($parametros["foto"]['tmp_name'], $parametros["foto"]['name'], $parametros["foto"]['type'], $parametros["foto"]['size'], $parametros["foto"]['error'], false); */
        $foto = $parametros["foto"];
        
        $ext = Foto::ObtenerExtension($foto);
        $imagenes = Foto::Subir_Imagen("foto", "./Fotos", $foto, "SI",1000 , 1000);
        Foto::AgregarMarcaDeAgua($imagenes["original"]);
        Foto::AgregarMarcaDeAgua($imagenes["mini"]);
        //Consigo la extensión de la foto.  
        
        if($ext != "ERROR"){
            //Guardo la foto.
            /*$rutaFoto = "./Fotos/Mesas/".$codigoMesa.".".$ext;
            Foto::GuardarFoto($foto,$rutaFoto);*/

            $respuesta = Pelicula::Insertar($nombre,$genero,$fecha_de_estreno,$cantidadDePublico,$imagenes["original"]);
            $newResponse = $response->withJson($respuesta,200);
            return $newResponse;
        }
        else{
            $respuesta = "Ocurrio un error.";
            $newResponse = $response->withJson($respuesta,200);
            return $newResponse;
        }        


        
     
    }


     public function CargarConImagen($request, $response, $args){
        
         /* $payload = $request->getAttribute("payload")["Payload"];
         $usuario=$payload->user; */

        /* $parametros = $request->getParsedBody(); */
        $json = $request->getBody();
        $parametros=json_decode($json, true);
        $files = $request->getUploadedFiles();
        $nombre = $parametros["nombre"];
        $genero = $parametros["genero"];
        $fecha_de_estreno = $parametros["fecha_de_estreno"];
        $cantidadDePublico = $parametros["cantidadDePublico"];
        /* $foto = $files["foto"]; */
 var_dump($_FILES);
        die();
        //Consigo la extensión de la foto.  
        $ext = Foto::ObtenerExtension($foto);
        
        if($ext != "ERROR"){
            //Genero el nombre de la foto.
            $nombreFoto = $nombre."_Foto".$ext;

            //Guardo la foto.
            $rutaFoto = "./IMGCompras/".$nombreFoto;
            Foto::GuardarFoto($foto,$rutaFoto);
    
            $respuesta = Pelicula::Insertar($nombre,$genero,$fecha_de_estreno,$cantidadDePublico,$rutaFoto);
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