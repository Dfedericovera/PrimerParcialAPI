<?php
    class Foto{
        public static function GuardarFoto($foto,$ruta){
            $foto->moveTo($ruta);
        }

        public static function ObtenerExtension($foto){
            $mediaType = $foto->getClientMediaType();
            $retorno = "";
            switch($mediaType){
                case "image/jpeg":
                    $retorno = ".jpg";
                    break;
                case "image/png":
                    $retorno = ".jpg";
                    break;
                default:
                    $retorno = "ERROR";
                    break;
            }

            return $retorno;
        }
    
        public static function BackupFoto($foto,$ruta){
        
            $destino = './Fotos/BackupFotos';           
            
                if (copy($ruta, $destino."foto_por_defecto.jpg")) { 
                    
                    echo "Se ha copiado correctamente el backup de la imagen";
            
                    }
                    
                    else {
                    
                    echo "No se copiado el backup de la imagen correctamente";
                    
                    }
        } 
        function Subir_Imagen($Input, $Ruta, $NombreFoto, $Miniatura, $AnchoMax, $AltoMax){
            /**
             * Sube una imagen 
             * @param string $Input Nombre del parametro ej ['foto']
             * @param string $Ruta Ruta donde se guardara la foto Termina con '/' ej /Fotos/FotosDePerfil/
             * @param string $NombreFoto Nombre de la foto
             * @param string $Miniatura Si recibe 'SI' crea una miniatura sino no.
             * @param int $AnchoMax Ancho maximo en px.
             * @param int $AltoMax Alto maximo en px.
             */
            /*$Respuesta = array();
            $Respuesta['Script']="";*/

            $NombreOriginal  = basename($_FILES[$Input]['name']);
            $Extension = pathinfo($NombreOriginal, PATHINFO_EXTENSION);
        
            if ($NombreFoto != '') { //Si el nombre esta vacio uso el orginal
                $Nombre = $NombreFoto.".".$Extension;//.'.'.$Extension; si viene sin extension la debo agregar
            } else {
                $Nombre = $_FILES[$Input]['name'].$Extension;
            }
        
        //Ruta de los archivos
            $ImagenOriginal = $Ruta.basename($Nombre);
            $ImagenMini = $Ruta."BackupFotos/"."Mini_".basename($Nombre);
        
        //Subo la imagen
            if (move_uploaded_file($_FILES[$Input]['tmp_name'],$ImagenOriginal)) {
                //redimensiono la imagen si es demasiado grande.
                if ($Extension == "jpg" || $Extension == "jpeg") { $ImagenGrande = imagecreatefromjpeg($ImagenOriginal);
                    } elseif ($Extension == "png") { $ImagenGrande = imagecreatefrompng($ImagenOriginal);
                    } elseif ($Extension == "gif") { $ImagenGrande = imagecreatefromgif($ImagenOriginal);
                    }
                    
                $x = imagesx($ImagenGrande);
                $y = imagesy($ImagenGrande);
                /*
                if($x <= $AnchoMax && $y <= $AltoMax){
                    $Respuesta['Script'] .= "Alerta('La imagen ya estaba optimizada.','success',3000);";
                    return json_encode($Respuesta);
                }*/ 
                if ($x >= $y) {
                    $nuevax = $AnchoMax;
                    $nuevay = $nuevax * $y / $x;
                    $Mininuevax = 200;
                    $Mininuevay = $Mininuevax * $y / $x;
                } else {
                    $nuevay = $AltoMax;
                    $nuevax = $x / $y * $nuevay;
                    $Mininuevay = 200;
                    $Mininuevax = $x / $y * $Mininuevay;
                }
        
                $ImagenNueva = imagecreatetruecolor($nuevax, $nuevay);
                imagecopyresized($ImagenNueva, $ImagenGrande, 0, 0, 0, 0, floor($nuevax), floor($nuevay), $x, $y);
        
                if ($Extension == "jpg" || $Extension == "jpeg") { imagejpeg($ImagenNueva,$ImagenOriginal,100);
                    } elseif ($Extension == "png") { imagepng($ImagenNueva,$ImagenOriginal,9);
                    } elseif ($Extension == "gif") { imagegif($ImagenNueva,$ImagenOriginal,100); }
        
                if($Miniatura == "SI") { //creo la miniatura
                    $Miniatura = imagecreatetruecolor($Mininuevax, $Mininuevay);
                    imagecopyresized($Miniatura, $ImagenGrande, 0, 0, 0, 0, floor($Mininuevax), floor($Mininuevay), $x, $y);
                    
                if ($Extension == "jpg" || $Extension == "jpeg") { imagejpeg($Miniatura,$ImagenMini,100);
                    } elseif ($Extension == "png") { imagepng($Miniatura,$ImagenMini,9);
                    } elseif ($Extension == "gif") { imagegif($Miniatura,$ImagenMini,100); }
                    imagedestroy($Miniatura);
                }
        
            } else {
                echo("Alerta(Ocurrió un error al subir la imagen.','error',3000);");
            }
        //imagedestroy($ImagenRedimensionada);
            
            $imagenes = array();
            $imagenes["original"]=$ImagenOriginal;
            $imagenes["mini"]=$ImagenMini;
            return $imagenes;
        }

        public static function AgregarMarcaDeAgua($rutaFoto){
            $estampa = imagecreatetruecolor(100, 70);
            imagefilledrectangle($estampa, 0, 0, 99, 69, 0x0000FF);
            imagefilledrectangle($estampa, 9, 9, 90, 60, 0xFFFFFF);
            $im = imagecreatefromjpeg($rutaFoto);
            imagestring($estampa, 5, 20, 20, 'TP_LAB3', 0x0000FF);
            imagestring($estampa, 3, 20, 40, '2019', 0x0000FF);

            // Establecer los márgenes para la estampa y obtener el alto/ancho de la imagen de la estampa
            $margen_dcho = 10;
            $margen_inf = 10;
            $sx = imagesx($estampa);
            $sy = imagesy($estampa);

            // Fusionar la estampa con nuestra foto con una opacidad del 50%
            imagecopymerge($im, $estampa, imagesx($im) - $sx - $margen_dcho, imagesy($im) - $sy - $margen_inf, 0, 0, imagesx($estampa), imagesy($estampa), 50);

            // Guardar la imagen en un archivo y liberar memoria
            imagepng($im, $rutaFoto);
            imagedestroy($im);                
        }
        

}
?>