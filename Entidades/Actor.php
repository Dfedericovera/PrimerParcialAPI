<?php
    include_once("DB/AccesoDatos.php");

    class Actor{


        public static function Insertar($Nombre,$Apellido,$Nacionalidad, $FechaDeNacimiento){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();            
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO actores (nombre,apellido,nacionalidad,fechaDeNacimiento)
                                                            VALUES(:nombre,:apellido,:nacionalidad,:fechaDeNacimiento)");            
            $consulta->bindValue(':nombre', $Nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido', $Apellido, PDO::PARAM_STR);
            $consulta->bindValue(':nacionalidad', $Nacionalidad, PDO::PARAM_STR);
            $consulta->bindValue(':fechaDeNacimiento', $FechaDeNacimiento, PDO::PARAM_STR);
            $consulta->execute();
        }
    

        public static function ConsultarTodos(){   

         $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
           $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM actores");
        
          $consulta->execute();        

          return $consulta->fetchAll(PDO::FETCH_CLASS,"Actor");
        }

    }
?>