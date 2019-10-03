<?php
    include_once("DB/AccesoDatos.php");
    class Usuario{
        public $id;
        public $usuario;
        public $tipo_usuario;

        public static function Login($user,$password){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT u.id, u.nombre, u.clave, u.perfil AS tipo_usuario  FROM usuarios u                                                         
                                                            WHERE u.nombre = :user AND u.clave = :clave ");//AND u.sexo = :sexo 
            

            $consulta->execute(array(":user" => $user, ":clave" => $password));
        
            $resultado = $consulta->fetchAll(PDO::FETCH_CLASS,"Usuario");
 
            return $resultado; 
        }

        public static function Insertar($nombre,$password,$perfil){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();            
            if($perfil=="")
                {$perfil="usuario";}
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (nombre,clave,perfil)
                                                            VALUES(:nombre,:clave,:perfil)");            
            $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $password, PDO::PARAM_STR);
            $consulta->bindValue(':perfil', $perfil, PDO::PARAM_STR);
            $consulta->execute();
        }
    

        public static function ConsultarTodos(){   

         $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
           $consulta = $objetoAccesoDato->RetornarConsulta("SELECT nombre ,clave ,id ,perfil FROM usuarios");
        
          $consulta->execute();        

          return $consulta->fetchAll(PDO::FETCH_CLASS,"Usuario");
        }

    }
?>