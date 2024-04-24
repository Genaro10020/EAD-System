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

    function consultarEtapasYFases(){
        global $conexion;
        $resultado = [];
        $estado = false;
        $consulta = "SELECT avance_fases.id_etapa, COUNT(*) as cantidad, avance_etapas.etapa FROM avance_fases JOIN avance_etapas ON avance_fases.id_etapa = avance_etapas.id GROUP BY avance_fases.id_etapa";
        $stmt = $conexion->prepare($consulta);
        if(!$stmt){
            $estado = "Error al preparar ".$conexion->error;
            return array($estado, $resultado);
        }
        if (!$stmt->execute()) {
            $estado = "Error en la ejecución de la sentencia SQL:".$stmt->error;
            return array($estado, $resultado);
        }
        $estado = true;
        $datos=$stmt->get_result();
        while ($fila=$datos->fetch_assoc()){ 
            $resultado [] = $fila;
        }
        $stmt->close();
        $conexion->close();
        return array($estado, $resultado);
    }

    function actualizarEstatus(){

    }

    function eliminar(){
       
    }
?>