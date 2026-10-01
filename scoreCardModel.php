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
        $estado[1] = true;
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {//SI EXISTE REGISTRO ACTUALIZAR
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
            
            }else{ //SI NO EXISTE NINGUNO INSERTAR INSERTAR
                $insertar = "INSERT INTO scorecard (id_equipo, id_ponderacion, id_criterio, input_valor_actual,input_puntos_obtenidos, input_ponderacion, anio, mes) VALUES (?,?,?,?,?,?,?,?)";//INSERTAR
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


    $stmt->close();
    $conexion->close();
    return array($estado, $resultado, $id);
    //return "llegue al modelo".$id_equipo.$id_ponderacion.$id_criterio.$input_valor_actual.$input_ponderacion.$mes;
}

function parsearMexTexto($mesStr)
{
    $meses = [
        "ENE" => 1, "ENERO" => 1,
        "FEB" => 2, "FEBRERO" => 2,
        "MAR" => 3, "MARZO" => 3,
        "ABR" => 4, "ABRIL" => 4,
        "MAY" => 5, "MAYO" => 5,
        "JUN" => 6, "JUNIO" => 6,
        "JUL" => 7, "JULIO" => 7,
        "AGO" => 8, "AGOSTO" => 8,
        "SEP" => 9, "SEPTIEMBRE" => 9,
        "OCTUBRE" => 10, "OCTUBRE" => 10,
        "NOV" => 11, "NOVIEMBRE" => 11,
        "DIC" => 12, "DICIEMBRE" => 12,        
    ];

    $clave = strtoupper(trim($mesStr));

    return $meses[$clave] ?? null;
}

function normalizarAnioInt($anioStr)
{
    $a = (int)$anioStr;
    if ($a < 100) {
        return 2000 + $a;        
    }

    return $a;
}

function obtenerPonderacionPeriodo($id_equipo, $anio, $mes)
{
    global $conexion;
    $estado = false;
    $id_ponderacion = null;
    $nombre_ponderacion = "";
    $hay_ponderacion = false;
    $anio = (int)$anio;
    $mes = (int)$mes;

    $consulta = "SELECT sc.id_ponderacion, p.ponderacion
                FROM scorecard sc
                LEFT JOIN ponderaciones p ON p.id = sc.id_ponderacion
                WHERE sc.id_equipo = ? AND sc.anio = ? AND sc.mes = ?
                    AND sc.id_ponderacion IS NOT NULL AND sc.id_ponderacion != 0
                LIMIT 1";

    $stmt = $conexion->prepare($consulta);
    if ($stmt) {
        $stmt->bind_param("iii", $id_equipo, $anio, $mes);
        if ($stmt->execute()) {
            $res = $stmt->get_result();
            if ($fila = $res->fetch_assoc()) {
                $id_ponderacion = (int)$fila['id_ponderacion'];
                $nombre_ponderacion = $fila['ponderacion'] ?? "";
                $hay_ponderacion = true;
            }
        }
        $stmt->close();
    }

    if (!$hay_ponderacion) {
        $queryArea = "SELECT area FROM equipos_ead WHERE id = ? LIMIT 1";
        $stmtArea = $conexion->prepare($queryArea);
        $nombreArea = "";
        $idArea = 0;
        if ($stmtArea) {
            $stmtArea->bind_param("i", $id_equipo);
            $stmtArea->execute();
            $resArea = $stmtArea->get_result();
            if ($filaArea = $resArea->fetch_assoc()) {
                $nombreArea = $filaArea['area'] ?? "";
            }
            $stmtArea->close();
        }

        if (!empty($nombreArea)) {
            $qIdArea = "SELECT id FROM areas WHERE nombre = ? LIMIT 1";
            $stmtIdArea = $conexion->prepare($qIdArea);
            if ($stmtIdArea) {
                $stmtIdArea->bind_param("s", $nombreArea);
                $stmtIdArea->execute();
                $resId = $stmtIdArea->get_result();
                if ($filaId = $resId->fetch_assoc()) {
                    $idArea = (int)$filaId['id'];
                }
                $stmtIdArea->close();
            }
        }

        $buscarAnio = "%" . $anio . "%";
        $qPond = "SELECT id, ponderacion FROM ponderaciones 
                    WHERE (area = ? OR area = 0) AND ponderacion LIKE ? 
                    ORDER BY id DESC LIMIT 1";
        $stmtPond = $conexion->prepare($qPond);
        if ($stmtPond) {
            $stmtPond->bind_param("is", $idArea, $buscarAnio);
            if ($stmtPond->execute()) {
                $resPond = $stmtPond->get_result();
                if ($filaPond = $resPond->fetch_assoc()) {
                    $id_ponderacion = (int)$filaPond['id'];
                    $nombre_ponderacion = $filaPond['ponderacion'];
                    $hay_ponderacion = true;
                }
            }
            $stmtPond->close();
        }
    }

    $estado = true;
    return array($estado, array(
        'hay_ponderacion' => $hay_ponderacion,
        'id_ponderacion' => $id_ponderacion,
        'nombre_ponderacion' => $nombre_ponderacion
    ));
} 

function actualizarTotal($total)
{
    /*$consulta = "SELECT * FROM cumplimiento_scorecard 
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
    }*/
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
