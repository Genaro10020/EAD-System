<?php
include("conexionGhoner.php");

    function consultarCompromisos($id_equipo){
        global $conexion;
        $estado1 = false;
        $estado2 = false;
        $resultado = [];
        $vueltas=0;
        $consulta = "SELECT * FROM compromisos WHERE id_equipo = ? AND proyecto_cerrado=''";//consulto los compromisos
        if ($stmt = $conexion->prepare($consulta)) {
            $stmt->bind_param("i",$id_equipo);
            if ($stmt->execute()) {
                $estado1 = true;
                $result = $stmt->get_result();
                while ($fila = $result->fetch_assoc()) {
                    $resultado[] = $fila;
                }
                include("conexionBDSugerencias.php");

                if(count($resultado)<=0){
                    $estado2 = true;
                }
                  for($i=0; $i<count($resultado);$i++){
                    $id = $resultado[$i]['id_responsable'];
                    //$id_equipo = $resultado[''];
                    $consulta = "SELECT * FROM usuarios_colocaboradores_sugerencias WHERE id = ?";//consulto el nombre del resposnable en tabla colaboradores
                        if ($stmt = $conexion->prepare($consulta)) {
                            $stmt->bind_param("i",$id);
                            if ($stmt->execute()) {
                                $estado2 = true;
                                $result = $stmt->get_result();
                                while ($fila = $result->fetch_assoc()) {
                                    $resultado[$i]['nombre_responsable'] = $fila['colaborador'];
                                    $resultado[$i]['nomina_colaborador'] = $fila['numero_nomina'];
                                }
                            } else {
                                $resultado = $stmt->error;
                            }
                        } else {
                            $resultado = $conexion->error;
                        }
                  }
                $stmt->close();
            } else {
                $resultado = $stmt->error;
            }
        } else {
            $resultado = $conexion->error;
        }
        return array($estado1, $resultado,$estado2);
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


