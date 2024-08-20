<?php
include("conexionGhoner.php");

    function consultarSession($id_equipo){
                global $conexion;
                $resultado = [];
                $estado = false;
                $consulta = "SELECT * FROM gestion_sesiones WHERE id_equipo=? AND proyecto_cerrado!='Si'";
                    $stmt = $conexion->prepare($consulta);
                    if(!$stmt){
                        $estado = "Error al preparar ".$conexion->error;
                        return array($estado, $resultado);
                    }
                    $stmt->bind_param("i", $id_equipo);
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

    function guardarActualizarSession($id_gestion_session,$accion,$id_equipo,$fecha,$etapa,$fases,$ids_integrantes,$asistencia,$porcentaje){
                    global $conexion;
                    $ids_integrantes=json_encode($ids_integrantes, JSON_UNESCAPED_UNICODE);
                    $asistencia=json_encode($asistencia, JSON_UNESCAPED_UNICODE);
                    $fases = json_encode($fases,JSON_UNESCAPED_UNICODE);
                    $etapa = json_encode($etapa,JSON_UNESCAPED_UNICODE);

                    if($accion==="Guardar"){
                        $guardar = "INSERT INTO gestion_sesiones (id_equipo, fecha, etapa, fase, ids_integrantes, asistencia, porcentaje_asistencia) VALUES (?,?,?,?,?,?,?)";
                        $stmt = $conexion->prepare($guardar);
                        if (!$stmt) {
                            return "IDQUIPO:".$id_equipo.$conexion->error;
                        }
                        $stmt->bind_param('isssssd',$id_equipo,$fecha,$etapa,$fases,$ids_integrantes,$asistencia,$porcentaje);
                    }else if ($accion==="Actualizar"){
                        $actualizar = "UPDATE gestion_sesiones SET fecha=?, etapa=?, fase=?, ids_integrantes=?, asistencia=?, porcentaje_asistencia=? WHERE id =?";
                        $stmt = $conexion->prepare($actualizar);
                        if (!$stmt) {
                            return "Actualizar:".$conexion->error;
                        }
                        $stmt->bind_param('sssssdi',$fecha,$etapa,$fases,$ids_integrantes,$asistencia,$porcentaje,$id_gestion_session);
                    }else{
                        return "el Modelo no identificó el tipo de acción";
                    }
                    if ($stmt->execute()) {
                        return true;
                    } else {
                        return $stmt->error;
                    }
    }

    function cerrarProyecto($id_equipo){
        $fecha = date('Y-m-d');
        global $conexion;
        $cerrado = "Si";
        $respuesta =[];
        $actualizar = "UPDATE gestion_sesiones SET proyecto_cerrado = ?, fecha_cierre = ? WHERE id_equipo = ?";
        $stmt = $conexion->prepare($actualizar);
        if (!$stmt){
            return $conexion->error;
        }else{
            $stmt->bind_param("ssi",$cerrado,$fecha,$id_equipo);
            if($stmt->execute()){
                $respuesta[0] = true; 
                        $actualizar = "UPDATE kpis_proyectos SET proyecto_cerrado = ?, fecha_cierre = ? WHERE id_equipo = ?";
                        $stmt = $conexion->prepare($actualizar);
                        if (!$stmt){
                            return $conexion->error;
                        }else{
                            $stmt->bind_param("ssi",$cerrado,$fecha,$id_equipo);
                            if($stmt->execute()){
                                $respuesta[1] = true; 
                                        $actualizar = "UPDATE compromisos SET proyecto_cerrado = ?, fecha_cierre = ? WHERE id_equipo = ?";
                                        $stmt = $conexion->prepare($actualizar);
                                        if (!$stmt){
                                            return $conexion->error;
                                        }else{
                                            $stmt->bind_param("ssi",$cerrado,$fecha,$id_equipo);
                                            if($stmt->execute()){
                                                $respuesta[2] = true; 
                                                        $actualizar = "UPDATE juntas_arranque SET proyecto_cerrado = ?, fecha_cierre = ? WHERE id_equipo = ?";
                                                        $stmt = $conexion->prepare($actualizar);
                                                        if (!$stmt){
                                                            return $conexion->error;
                                                        }else{
                                                            $stmt->bind_param("ssi",$cerrado,$fecha,$id_equipo);
                                                            if($stmt->execute()){
                                                                $respuesta[3] = true; 
                                                            }else{
                                                                return $stmt->error;
                                                            }
                                                        }
                                            }else{
                                                return $stmt->error;
                                            }
                                        }
                            }else{
                                return $stmt->error;
                            }
                        }
            }else{
                return $stmt->error;
            }
        }
        return $respuesta;
    }

    function eliminarSession($id_session){
       global $conexion;
       $delete = "DELETE FROM gestion_sesiones WHERE id =?";
       $stmt = $conexion->prepare($delete);
       if(!$stmt){
        return "Error al preprar la consulta".$conexion->error;
       }
       $stmt->bind_param("i",$id_session);
       if($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                return "No se encontró ninguna sesión con el ID proporcionado";
            }
       }else{
        return "Error en los parametos".$stmt->error;
       }
    }


    function consultarSessionAsistencia($id_equipo,$anio,$mes){
        $fecha = $anio."-".$mes;
        global $conexion;
        $resultado = [];
        $estado = false;
        $consulta = "SELECT * FROM gestion_sesiones WHERE id_equipo=?  AND DATE_FORMAT(fecha, '%Y-%m') = '$fecha'";
            $stmt = $conexion->prepare($consulta);
            if(!$stmt){
                $estado = "Error al preparar ".$conexion->error;
                return array($estado, $resultado);
            }
            $stmt->bind_param("i", $id_equipo);
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
        return array($estado, $resultado,$fecha);
}
?>