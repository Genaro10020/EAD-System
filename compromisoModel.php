<?php
include("conexionGhoner.php");
    function consultarCompromisos(){
        global $conexion;
        $estado = false;
        $resultado = [];

        $consulta = "SELECT * FROM compromisos";
        if ($stmt = $conexion->prepare($consulta)) {
            if ($stmt->execute()) {
                $estado = true;
                $result = $stmt->get_result();
                while ($fila = $result->fetch_assoc()) {
                    $resultado[] = $fila;
                }
                $stmt->close();
            } else {
                $resultado = $stmt->error;
            }
        } else {
            $resultado = $conexion->error;
        }
    
        return array($estado, $resultado);
    }
