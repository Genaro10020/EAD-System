<?php
include("conexionGhoner.php");

    function consultarCapacitacion($area){
        global $conexion;
        $estado1 = false;
        $resultado = [];
        $vueltas=0;
        $consulta = "SELECT * FROM capacitaciones WHERE area = ? ORDER BY id DESC";//consulto las capacitaciones
        if ($stmt = $conexion->prepare($consulta)) {
            $stmt->bind_param("s",$area);
            if ($stmt->execute()) {
                $estado1 = true;
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
        return array($estado1, $resultado);
    }

    function guardarCapacitacion($area,$fecha,$ingresos,$comentario){
        global $conexion;
        $estatus = 0;
        $insertar = "INSERT INTO capacitaciones (area,fecha,ingresos,comentario) VALUES (?,?,?,?)";
        $stmt = $conexion->prepare($insertar);
            if(!$stmt){return "Error al insertar ".$conexion->error;}
        $stmt->bind_param('ssss',$area,$fecha,$ingresos,$comentario);
            if (!$stmt->execute()) {  return "Error en la ejecución del insert: " . $stmt->error; }
        $stmt->close();
        $conexion->close();
        return true;
    }

    function actualizarCapacitacion($id,$fecha,$ingresos,$comentario){
        global $conexion;
        $actualizar = "UPDATE capacitaciones SET fecha=?, ingresos=?, comentario=? WHERE id=?";
        $stmt = $conexion->prepare($actualizar);
            if(!$stmt){return "Error al actualizar ".$conexion->error;}
        $stmt->bind_param('sssi',$fecha,$ingresos,$comentario,$id);
            if (!$stmt->execute()) {  return "Error en la ejecución del actualización: " . $stmt->error; }
        $stmt->close();
        $conexion->close();
        return true;
    }

    /*function actualizarPorcentaje($compromiso_id,$porcentaje){
        global $conexion;
        $actualizar = "UPDATE compromisos SET estatus=? WHERE id=?";
        $stmt = $conexion->prepare($actualizar);
            if(!$stmt){return "Error al actualizar ".$conexion->error;}
        $stmt->bind_param('ii',$porcentaje,$compromiso_id);
            if (!$stmt->execute()) { return "Error en la ejecución del actualización: " . $stmt->error; }
        $stmt->close();
        $conexion->close();
        return true;
    }

    function eliminarCompromiso($id_compromiso){
        global $conexion;
        $delete = "DELETE FROM compromisos WHERE id=?";
        $stmt = $conexion->prepare($delete);
            if(!$stmt){return "Error al eliminar ".$conexion->error;}
        $stmt->bind_param('i',$id_compromiso);
            if (!$stmt->execute()) {  return "Error en la ejecución de eliminar: " . $stmt->error; }
        $stmt->close();
        $conexion->close();
        return true;
    }*/


