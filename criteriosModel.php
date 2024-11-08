<?php
include("conexionGhoner.php");

function consultarCriterios()
{
    global $conexion;
    $resultado = [];
    $estado = false;
    $consulta = "SELECT * FROM criterios";
    $stmt = $conexion->prepare($consulta);
    if (!$stmt) {
        $estado = "Error al preparar " . $conexion->error;
        return array($estado, $resultado);
    }
    if (!$stmt->execute()) {
        $estado = "Error en la ejecución de la sentencia SQL:" . $stmt->error;
        return array($estado, $resultado);
    }
    $estado = true;
    $datos = $stmt->get_result();
    while ($fila = $datos->fetch_array()) {
        $resultado[] = $fila;
    }

    $stmt->close();
    $conexion->close();
    return array($estado, $resultado);
}
function consultarCriteriosPonderacion($id_equipo)
{
    global $conexion;
    $resultado = [];
    $estado = false;
    $consulta = "SELECT DISTINCT criterios.id,criterios.nombre,criterios.operacion FROM equipos_ead JOIN ponderaciones ON equipos_ead.id_ponderacion = ponderaciones.id JOIN datos_ponderaciones ON ponderaciones.id = datos_ponderaciones.id_ponderacion JOIN criterios ON criterios.id = datos_ponderaciones.id_criterios WHERE equipos_ead.id=? AND criterios.tipo='Gráfica'";
    $stmt = $conexion->prepare($consulta);
    if (!$stmt) {
        $estado = "Error al preparar " . $conexion->error;
        return array($estado, $resultado);
    }
    $stmt->bind_param('i', $id_equipo);
    if (!$stmt->execute()) {
        $estado = "Error en la ejecución de la sentencia SQL:" . $stmt->error;
        return array($estado, $resultado);
    }
    $estado = true;
    $datos = $stmt->get_result();
    while ($fila = $datos->fetch_array()) {
        $resultado[] = $fila;
    }

    $stmt->close();
    $conexion->close();
    return array($estado, $resultado);
}

function consultarCriteriosColaborador($id_equipo,$id_criterio)
{
    global $conexion;
    $resultado = [];
    $estado = false;
    $consulta = "SELECT DISTINCT criterios.id,criterios.nombre FROM equipos_ead JOIN ponderaciones ON equipos_ead.id_ponderacion = ponderaciones.id JOIN datos_ponderaciones ON ponderaciones.id = datos_ponderaciones.id_ponderacion JOIN criterios ON criterios.id = datos_ponderaciones.id_criterios WHERE equipos_ead.id=? AND criterios.tipo='Gráfica' AND criterios.id = ? ";
    $stmt = $conexion->prepare($consulta);
    if (!$stmt) {
        $estado = "Error al preparar " . $conexion->error;
        return array($estado, $resultado);
    }
    $stmt->bind_param('ii', $id_equipo,$id_criterio);
    if (!$stmt->execute()) {
        $estado = "Error en la ejecución de la sentencia SQL:" . $stmt->error;
        return array($estado, $resultado);
    }
    $estado = true;
    $datos = $stmt->get_result();
    while ($fila = $datos->fetch_array()) {
        $resultado[] = $fila;
    }

    $stmt->close();
    $conexion->close();
    return array($estado, $resultado);
}

function guardarNuevoCriterio($nuevo,$tipo){
   
        global $conexion;
        $answer = false;
        $guardar = "INSERT INTO criterios (nombre,tipo) VALUES (?,?)";
        $stmt = $conexion->prepare($guardar);
        if(!$stmt){return $conexion->error;}
        $stmt->bind_param("ss",$nuevo,$tipo);
        if(!$stmt->execute()){return $stmt->error;}
        $answer = true;
        return $answer;

}

function actualizarEstatus($id_foro, $nuevoEstatus)
{
    global $conexion;
    $estado = false;
    $update = "UPDATE foros SET estatus=? WHERE id=?";
    $stmt = $conexion->prepare($update);
    $stmt->bind_param("si", $nuevoEstatus, $id_foro);
    if ($stmt->execute()) {
        $estado = true;
    }
    $stmt->close();
    return $estado;
}

function eliminar()
{
}
