<?php
include("conexionGhoner.php");

function consultarCumplimientoScorecard($id_area,$mes,$anio)
{
    global $conexion;
    $estado = false;
    $resultado = [];
    $param_mes = "%$mes%";
    $proyectoPuntos = [];
        $consulta = "SELECT cumplimiento_scorecard.*,equipos_ead.nombre_ead, equipos_ead.id AS idEquipo
        FROM cumplimiento_scorecard 
        INNER JOIN equipos_ead 
        ON cumplimiento_scorecard.id_ead = equipos_ead.id 
        WHERE cumplimiento_scorecard.id_area=? 
        /*LIKE cumplimiento_scorecard.mes=? */
        AND cumplimiento_scorecard.anio=?";
        $stmt = $conexion->prepare($consulta);
        $stmt->bind_param("si", $id_area,$anio);
        if ($stmt) {
            if ($stmt->execute()) {
                $estado = true;
                $datos = $stmt->get_result();
                while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) { 
                 
                    if (!isset($proyectoPuntos[$fila['nombre_ead']])) {
                        $proyectoPuntos[$fila['nombre_ead']] =[];
                    }
                    $proyectoPuntos[$fila['nombre_ead']][] = [
                        'idEquipo' => $fila['idEquipo'],
                        'nombre_equipo' =>$fila['nombre_ead'],
                        'mes' => $fila['mes'], 
                        'puntos' => $fila['puntos'] 
                    ];
                }
                // Almacena el resultado final
                $resultado = $proyectoPuntos; // No es necesario convertir a array indexado
            } else {
                $estado = "Error al consultar la base de datos" . $conexion->error;
            }
        } else {
            return $conexion->error;
        }

    return array($estado, $resultado);
}

function insertarActualizarScoreCardPuntos($id_equipo, $mes, $anio, $total)
{
    global $conexion;
    $estado = [];


    //para actualizar en caso de que ya exista el total en cumplimiento_scorecard
    $consulta = "SELECT * FROM cumplimiento_scorecard
    WHERE id_ead=? AND anio=? AND mes=? ";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("iii", $id_equipo,$anio,$mes);
    if ($stmt) {
       
        if ($stmt->execute()) {
            $respuesta = $stmt->get_result();
            if ($respuesta->num_rows > 0) {
                $fila = $respuesta->fetch_assoc();
                $id = $fila['id'];
                $fecha_actual = date('Y-m-d H:i:s');
                $actualizar = "UPDATE cumplimiento_scorecard SET puntos=?, fecha_actualizacion=?
                WHERE id = ? AND anio=? AND mes=?";
                $stmt = $conexion->prepare($actualizar);
                if($stmt){
                    $stmt->bind_param("isiii", $total,$fecha_actual,$id,$anio,$mes);
                    if($stmt->execute()){
                        $estado = true;
                    }else{
                        $estado = $stmt->error;
                    }
                }else{
                    $estado = $conexion->error;
                }
            }else{//Si no existe registro se ejecuta este bloque.

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

                $insertar = "INSERT INTO cumplimiento_scorecard (id_ead, id_area, anio, mes, puntos,fecha_creacion,fecha_actualizacion) VALUES (?,?,?,?,?,?,?)";
                $stmt = $conexion->prepare($insertar);
                if ($stmt) {
                    $fecha_actual = date('Y-m-d H:i:s');
                    $stmt->bind_param("iiiiiss", $id_equipo, $id_area, $anio, $mes, $total,$fecha_actual,$fecha_actual);
                    if ($stmt->execute()) {
                        $estado = true;
                    } else {
                        $estado = $stmt->error;
                    }
                } else {
                    $estado = $conexion->error;
                }
                
            }
        }else {
            $estado = $stmt->error;
        }
    }else{
        $estado = $conexion->error;
    }


    $stmt->close();
    $conexion->close();
    return array($estado);
    //return "llegue al modelo".$id_equipo.$id_ponderacion.$id_criterio.$input_valor_actual.$input_ponderacion.$mes;
}




