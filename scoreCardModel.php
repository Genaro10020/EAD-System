<?php
include("conexionGhoner.php");

function consultar($id_equipo, $id_ponderacion, $anio, $mes)
{
    global $conexion;
    $estado = false;
    $resultado = [];
    $consulta = "SELECT * FROM scorecard WHERE id_equipo=? AND id_ponderacion = ? AND	anio=? AND 	mes=?";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("iiii", $id_equipo, $id_ponderacion, $anio, $mes);
    if ($stmt) {
        if ($stmt->execute()) {
            $estado = true;
            $datos = $stmt->get_result();
            while ($fila = $datos->fetch_array()) {
                $resultado[] = $fila;
            }
        } else {
            $estado = "Error al consultar la base de datos" . $conexion->error;
        }
    } else {
        return $conexion->error;
    }
    return array($estado, $resultado);
}

function consultarInsertarActualizar($id_equipo, $id_ponderacion, $id_criterio, $input_valor_actual, $puntos_obtenidos, $input_ponderacion, $anio, $mes, $total)
{
    global $conexion;
    $estado = [];
    $resultado = [];
    $respuesta=[];
    $id = "";
    if ($input_valor_actual == "") {
        $input_valor_actual = null;
    }
    if ($puntos_obtenidos == "") {
        $puntos_obtenidos = null;
    }
    if ($input_ponderacion == "") {
        $input_ponderacion = null;
    }
    $consulta = "SELECT * FROM scorecard WHERE id_equipo=? AND id_ponderacion = ? AND id_criterio=? AND	anio=? AND 	mes=?";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("iiiii", $id_equipo, $id_ponderacion, $id_criterio, $anio, $mes);
    if ($stmt) {
        $estado[1] = "Si busque";
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) { //Si existe registro y tomo el id ACTUALIZAR
                $fila = $resultado->fetch_assoc();
                $id = $fila['id'];
                $update = "UPDATE scorecard SET input_valor_actual=?, input_ponderacion=? WHERE id = ?";
                $stmt = $conexion->prepare($update);
                $stmt->bind_param("ssi", $input_valor_actual, $input_ponderacion, $id);
                if ($stmt) {
                    if ($stmt->execute()) {
                        $estado[2] = true;
                    }else {
                        $estado[2] = $stmt->error;
                    }
                }else {
                    $estado[0] = "Error al actualizar" . $conexion->error;
                }
            
            }else{ //Si no exite ninguno INSERTAR
                $insertar = "INSERT INTO scorecard (id_equipo, id_ponderacion, id_criterio, input_valor_actual,input_puntos_obtenidos, input_ponderacion, anio, mes) VALUES (?,?,?,?,?,?,?,?)";
                $stmt = $conexion->prepare($insertar);
                if($stmt){
                    $stmt->bind_param("iiisssii", $id_equipo, $id_ponderacion, $id_criterio, $input_valor_actual, $puntos_obtenidos, $input_ponderacion, $anio, $mes);
                    if($stmt->execute()) {
                        $estado[2] = true;
                    }else{
                        $estado[2] = $stmt->error;
                    }
                }else{
                    $estado[4] = $conexion->error;
                }

            }
        }else {
            $estado[2] = $stmt->error;
        }

    }else{
        $estado[1] = $conexion->error;
    }

    //para actualizar en caso de que ya exista el total en cumplimiento_scorecard
    $consulta = "SELECT * FROM cumplimiento_scorecard 
    WHERE id_ead=? AND anio=? AND mes=? ";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("iii", $id_equipo,$anio,$mes);
    if ($stmt) {
        $estado[1] = "Si busque";
        if ($stmt->execute()) {
            $respuesta = $stmt->get_result();
            if ($respuesta->num_rows > 0) {
                $fila = $respuesta->fetch_assoc();
                $id = $fila['id'];
                $actualizar = "UPDATE cumplimiento_scorecard SET puntos=?
                WHERE id = ?";
                $stmt = $conexion->prepare($actualizar);
                if($stmt){
                    $stmt->bind_param("ii", $total, $id);
                    if($stmt->execute()) {
                        $estado[2] = true;
                    }else{
                        $estado[2] = $stmt->error;
                    }
                }else{
                    $estado[4] = $conexion->error;
                }
            }else{

                //consultamos el area
                $consulta = "SELECT area FROM equipos_ead 
                WHERE id=?";
                $stmt = $conexion->prepare($consulta);
                $stmt->bind_param("i", $id_equipo);
                if ($stmt) {
                    if ($stmt->execute()) {
                        $estado = true;
                        $datos = $stmt->get_result();
                        while ($fila = $datos->fetch_array()) {
                            $area = $fila['area'];
                        }
                    } else {
                        $estado = "Error al consultar la base de datos" . $conexion->error;
                    }

                    //consultamos el id del area en base al area que conseguimos en la consulta de arriba
                    $consulta = "SELECT id FROM areas 
                    WHERE nombre=?";
                    $stmt = $conexion->prepare($consulta);
                    $stmt->bind_param("s", $area);
                    if ($stmt) {
                        if ($stmt->execute()) {
                            $estado = true;
                            $datos = $stmt->get_result();
                            while($fila = $datos->fetch_array()){
                                $id_area = $fila['id'];
                            }
                        }else {
                            $estado = "Error al consultar la base de datos" . $conexion->error;
                        }
                    }
                }

                $insertar = "INSERT INTO cumplimiento_scorecard (id_ead, id_area, anio, mes, puntos) VALUES (?,?,?,?,?)";
                $stmt = $conexion->prepare($insertar);
                if ($stmt) {
                    $stmt->bind_param("iiiii", $id_equipo, $id_area, $anio, $mes, $total);
                    if ($stmt->execute()) {
                        $estado[2] = true;
                    } else {
                        $estado[2] = $stmt->error;
                    }
                } else {
                    $estado[4] = $conexion->error;
                }
                
            }
        }else {
            $estado[2] = $stmt->error;
        }
    }else{
        $estado[1] = $conexion->error;
    }


    $stmt->close();
    $conexion->close();
    return array($estado, $resultado, $id);
    //return "llegue al modelo".$id_equipo.$id_ponderacion.$id_criterio.$input_valor_actual.$input_ponderacion.$mes;
}

function actualizarTotal($total)
{
    $consulta = "SELECT * FROM cumplimiento_scorecard 
    WHERE id_ead=? AND anio=? AND mes=? ";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("iii", $id_equipo,$anio,$mes);
    if ($stmt) {
        $estado[1] = "Si busque";
        if ($stmt->execute()) {
            $respuesta = $stmt->get_result();
            if ($respuesta->num_rows > 0) {
                $fila = $respuesta->fetch_assoc();
                $id = $fila['id'];
                $actualizar = "UPDATE cumplimiento_scorecard SET puntos=?
                WHERE id = ?";
                $stmt = $conexion->prepare($actualizar);
                if($stmt){
                    $stmt->bind_param("ii", $total, $id);
                    if($stmt->execute()) {
                        $estado[2] = true;
                    }else{
                        $estado[2] = $stmt->error;
                    }
                }else{
                    $estado[4] = $conexion->error;
                }
            }
        }
    }
}

function actualizarEstatus()
{
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

function eliminar()
{
}
