<?php
include("conexionBDSugerencias.php");

    function consultar(){
   
    }

    function insertarColaborador($nombre,$nomina,$password,$planta){
        global $conexion;
        $insertar = "INSERT INTO usuarios_colocaboradores_sugerencias (colaborador, numero_nomina, password, planta) VALUES (?,?,?,?)";
        $stmt = $conexion->prepare($insertar);
        if(!$stmt){
            return $conexion->error;
        }
        $stmt->bind_param("ssss", $nombre, $nomina, $password, $planta);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            $respuesta = true;
        }else{
            return $stmt->error;
        }
        return $respuesta;
    }

    function actualizar(){
      
    }

    function eliminar(){
       
    }
?>