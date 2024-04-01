<?php
include("conexionGhoner.php");

    function consultarFaseXIDEtapa($id_etapa){
        global $conexion;
        $resultado = [];
        $estado = false;
        $consulta = "SELECT * FROM avance_fases WHERE id_etapa=?";
            $stmt = $conexion->prepare($consulta);
            if(!$stmt){
                $estado = "Error al preparar ".$conexion->error;
                return array($estado, $resultado);
            }
            $stmt->bind_param("i", $id_etapa);
            if (!$stmt->execute()) {
                $estado = "Error en la ejecución de la sentencia SQL:".$stmt->error;
                return array($estado, $resultado);
            }
            $estado = true;
            $datos=$stmt->get_result();
            while ($fila=$datos->fetch_array()){ 
                $resultado [] = $fila;
            }
        
        $stmt->close();
        $conexion->close();
        return array($estado, $resultado);
    }

    function insertar(){
   
    }

    function actualizarEstatus(){

    }

    function eliminar(){
       
    }
?>