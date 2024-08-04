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

function consultarInsertarActualizar($id_equipo, $id_ponderacion, $id_criterio, $input_valor_actual, $puntos_obtenidos, $input_ponderacion, $anio, $mes)
{
    global $conexion;
    $estado = [];
    $resultado = [];
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
                    } else {
                        $estado[2] = $stmt->error;
                    }
                } else {
                    $estado[0] = "Error al actualizar" . $conexion->error;
                }
            } else { //Si no exite ninguno INSERTAR
                $insertar = "INSERT INTO scorecard (id_equipo, id_ponderacion, id_criterio, input_valor_actual,input_puntos_obtenidos, input_ponderacion, anio, mes) VALUES (?,?,?,?,?,?,?,?)";
                $stmt = $conexion->prepare($insertar);
                if ($stmt) {
                    $stmt->bind_param("iiisssii", $id_equipo, $id_ponderacion, $id_criterio, $input_valor_actual, $puntos_obtenidos, $input_ponderacion, $anio, $mes);
                    if ($stmt->execute()) {
                        $estado[2] = true;
                    } else {
                        $estado[2] = $stmt->error;
                    }
                } else {
                    $estado[4] = $conexion->error;
                }
            }
        } else {
            $estado[2] = $stmt->error;
        }
    } else {
        $estado[1] = $conexion->error;
    }
    $stmt->close();
    $conexion->close();
    return array($estado, $resultado, $id);
    //return "llegue al modelo".$id_equipo.$id_ponderacion.$id_criterio.$input_valor_actual.$input_ponderacion.$mes;
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
