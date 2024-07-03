<?php
include("conexionGhoner.php");

    function consultarPonderacion(){
        global $conexion;
        $datos = [];
        $estado = false;
        $consulta = "SELECT * FROM ponderaciones";
        $stmt = $conexion->prepare($consulta);
        if($stmt->execute()){
            $estado = true;
            $resultados = $stmt->get_result();
            while ($fila = $resultados->fetch_array()) {
                $datos[] = $fila;
            }
        }
        $stmt->close();
        $conexion->close();
        return array($estado,$datos);
    }

    function guardarNuevaPonderacion($nombre,$nuevaPonderacion){
        global $conexion;
        foreach ($nuevaPonderacion as $criterio => $parametros) {
            foreach ($parametros as $parametro => $valores) {
                $desde = $valores[0];
                $hasta = $valores[1];
                $puntos = $valores[2];
                if($desde==''){$desde=null;}
                if($hasta==''){$hasta=null;}
                if($puntos==''){$puntos=null;}
    
                $insertar = "INSERT INTO ponderaciones (ponderacion, criterio, parametro, desde, hasta, puntos) VALUES (?,?,?,?,?,?);";
                $stmt = $conexion->prepare($insertar);
                $stmt->bind_param("sssiii", $nombre, $criterio, $parametro, $desde, $hasta, $puntos);
                if ($stmt->execute()) {
                    $resultado = true;
                } else {
                    $resultado = "Error en la consulta: ". $conexion->error;
                }
            }
        }
         return $resultado;
    }



    function actualizar(){
        /*global $conexion;
        $estado = false;
        $update = "UPDATE foros SET estatus=? WHERE id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("si", $nuevoEstatus, $id_foro);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;*/
    }

    function eliminar(){
       
    }
?>