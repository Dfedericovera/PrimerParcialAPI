<?php
include_once("DB/AccesoDatos.php");

class Pelicula
{
        

    public function __toString()
    {
        return $this->marca . " - " . $this->modelo . " - " . $this->precio . " - " . $this->fecha;
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

    public static function Insertar($nombre, $Tipo, $FechaDeEstreno, $cantidadDePublico)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO peliculas (nombre, Tipo, FechaDeEstreno, cantidadDePublico )
                                                        VALUES(:nombre, :Tipo, :FechaDeEstreno , :cantidadDePublico)");

        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindValue(':Tipo', $Tipo, PDO::PARAM_STR);
        $consulta->bindValue(':FechaDeEstreno', $FechaDeEstreno, PDO::PARAM_STR);
        $consulta->bindValue(':cantidadDePublico', $cantidadDePublico, PDO::PARAM_INT);
        $consulta->execute();
    }
}
