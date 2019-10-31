<?php
include_once("DB/AccesoDatos.php");

class Pelicula
{
        

    public function __toString()
    {
        return $this->marca . " - " . $this->modelo . " - " . $this->precio . " - " . $this->fecha;
    }
    public static function EliminarPelicula($id)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM peliculas WHERE id=:id");

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
    }


    public static function ConsultarTodos()
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM peliculas");

        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, "Pelicula");
    }


    public static function ConsultarMarca($marca)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT marca, modelo, fecha, precio FROM compra WHERE marca = :marca");
        $consulta->bindValue(':marca', $marca, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, "Compra");
    }
    public static function ConsultarCompras($usuario, $perfil)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        if ($perfil == "admin") {
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT marca, modelo, fecha, precio FROM compra");
            $consulta->execute();
        }
        if ($perfil != "admin") {
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT marca, modelo, fecha, precio 
                                                            FROM compra");
            $consulta->bindValue(':usuario', $usuario, PDO::PARAM_INT);
            $consulta->execute();
        }
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Compra");
    }
        /**
 * Devuelve la información sobre la transaccion
 *
 * This method is used to Insert a object
 * <b>Note:</b> it is not required that
 * the user be currently logged in.
 *
 * @access public
 * @param string $nombre user name of the account
 * @param string $tipo genero de la pelicula
 * @param string $FechaDeEstreno fecha de estreno de la pelicula
 * @param int    $cantidadDePublico cantidad de publico
 * @param string $rutaDeFoto ruta de la foto
 * @return Account
 */
    public static function Insertar($nombre, $Tipo, $FechaDeEstreno, $cantidadDePublico, $rutaDeFoto)
    {

        try{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO peliculas (nombre, Tipo, FechaDeEstreno, cantidadDePublico, Foto )
                                                        VALUES(:nombre, :Tipo, :FechaDeEstreno , :cantidadDePublico, :Foto)");

        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindValue(':Tipo', $Tipo, PDO::PARAM_STR);
        $consulta->bindValue(':FechaDeEstreno', $FechaDeEstreno, PDO::PARAM_STR);
        $consulta->bindValue(':cantidadDePublico', $cantidadDePublico, PDO::PARAM_INT);
        $consulta->bindValue(':Foto', $rutaDeFoto, PDO::PARAM_STR);
        $consulta->execute();

        $resultado = array("Estado" => "OK", "Mensaje" => "Insertado Correctamente");
        }
        catch(Exception $e){
            $mensaje = $e->getMessage();
            $resultado = array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
        finally{
            return $resultado;
        }

        
    }
}
