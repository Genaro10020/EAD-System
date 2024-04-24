<?php
include("conexionGhoner.php");
    function consultarCompromisos($id_equipo){
        global $conexion;
        $estado = false;
        $resultado = [];

        $consulta = "SELECT *, compromisos.id AS id FROM compromisos LEFT JOIN usuarios ON compromisos.id_responsable = usuarios.id WHERE id_equipo = ?";
        if ($stmt = $conexion->prepare($consulta)) {
            $stmt->bind_param("i",$id_equipo);
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

    function guardarCompromiso($id_equipo,$fecha,$compromiso,$responsable){
        global $conexion;
        $estatus = 0;
        $insertar = "INSERT INTO compromisos (id_equipo,compromiso,id_responsable,fecha,estatus) VALUES (?,?,?,?,?)";
        $stmt = $conexion->prepare($insertar);
            if(!$stmt){return "Error al inserta ".$conexion->error;}
        $stmt->bind_param('isssi',$id_equipo,$compromiso,$responsable,$fecha,$estatus);
            if (!$stmt->execute()) {  return "Error en la ejecución del insert: " . $stmt->error; }
        $stmt->close();
        $conexion->close();
        return true;
    }

    function actualizarCompromiso($id_compromiso,$fecha,$compromiso,$responsable){
        global $conexion;
        $actualizar = "UPDATE compromisos SET compromiso=?,id_responsable=?,fecha=? WHERE id=?";
        $stmt = $conexion->prepare($actualizar);
            if(!$stmt){return "Error al actualizar ".$conexion->error;}
        $stmt->bind_param('sisi',$compromiso,$responsable,$fecha,$id_compromiso);
            if (!$stmt->execute()) {  return "Error en la ejecución del actualización: " . $stmt->error; }
        $stmt->close();
        $conexion->close();
        return true;
    }

    function actualizarPorcentaje($compromiso_id,$porcentaje){
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
    }


