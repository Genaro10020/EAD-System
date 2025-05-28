<?php
include("conexionGhoner.php");

    function consultandoPilares(){
        global $conexion;
        $estado1 = false;
        $resultado = [];
        $vueltas=0;
        $consulta = "SELECT pilares.id AS pilarID, pilares.nombre AS pilarNombre, objetivos_estrategicos.id AS objetivoID ,objetivos_estrategicos.nombre AS objetivoNombre 
        FROM pilares INNER JOIN objetivos_estrategicos ON pilares.id = objetivos_estrategicos.id_pilares";//consulto las capacitaciones
        if ($stmt = $conexion->prepare($consulta)) {
            if ($stmt->execute()) {
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
        return ($resultado);
    }
    function guardandoSeleccionados($pilar, $objetivo, $id_equipo, $nombre){
        $pilar_string=json_encode($pilar, JSON_UNESCAPED_UNICODE);
        $objetivo_string=json_encode($objetivo, JSON_UNESCAPED_UNICODE);

        if (empty($pilar)) {
            $pilar_string = "";
        }
        if (empty($objetivo)) {
            $objetivo_string = "";
        }
        
        global $conexion;
        $estatus = 0;
        $actualizar = "UPDATE kpis_proyectos SET pilares=?, objetivos=? WHERE id_equipo=? AND nombre_indicador=?";
        $stmt = $conexion->prepare($actualizar);
            if(!$stmt){return "Error al insertar ".$conexion->error;}
        $stmt->bind_param('ssis',$pilar_string, $objetivo_string, $id_equipo, $nombre);
            if (!$stmt->execute()) {  return "Error en la ejecución del insert: " . $stmt->error; }
        $stmt->close();
        $conexion->close();
        return true;
    }
/*
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
    }*/
