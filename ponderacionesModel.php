<?php
include("conexionGhoner.php");

function consultarTablaPonderaciones()
{
    global $conexion;
    $estado = false;
    $resultado = array();
    $consulta = "SELECT * FROM ponderaciones";
    $query = $conexion->query($consulta);
    if ($query) {
        $estado = true;
        while ($datos = $query->fetch_array()) {
            $resultado[] = $datos;
        }
    } else {
        $estado = $conexion->error;
    }

    return array($estado, $resultado);
}


function consultarPonderacion()
{
    global $conexion;
    $datos = [];
    $estado = false;
    $area = $_SESSION['area'];

    $consulta = "SELECT ponderaciones.ponderacion,ponderaciones.area,datos_ponderaciones.*,criterios.nombre AS criterio 
    FROM ponderaciones
    INNER JOIN datos_ponderaciones ON ponderaciones.id = datos_ponderaciones.id_ponderacion
    INNER JOIN criterios ON criterios.id = datos_ponderaciones.id_criterios
    LEFT JOIN areas ON areas.id = ponderaciones.area
    WHERE areas.nombre = '$area' OR ponderaciones.area = 0
    ORDER BY ponderaciones.id DESC";
    $stmt = $conexion->prepare($consulta);
    if (!$stmt) {
        return array($conexion->error, $datos);
    }
    if ($stmt->execute()) {
        $estado = true;
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_array()) {
            $datos[] = $fila;
        }
    } else {
        $estado = $stmt->error;
    }
    $stmt->close();
    $conexion->close();
    return array($estado, $datos);
}

function actualizarAsignacion($id_ead, $id_ponderacion)
{
    global $conexion;
    $actualizar = "UPDATE equipos_ead SET id_ponderacion = ? WHERE id = ?";
    $stmt = $conexion->prepare($actualizar);
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param("si", $id_ponderacion, $id_ead);
    if ($stmt->execute()) {
        return true;
    } else {
        return $stmt->error;
    }
    $stmt->close();
}

function insertarArea($nombre,$id)
{
    global $conexion;

    $consulta = "SELECT id FROM areas WHERE nombre = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado) {
        $datos = $resultado->fetch_array();
        $idArea = $datos['id'];
    }

    $actualizar = "UPDATE ponderaciones SET area = ? WHERE id = ?";
    $stmt = $conexion->prepare($actualizar);
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param("ii", $idArea, $id);
    if ($stmt->execute()) {
        return true;
    } else {
        return $stmt->error;
    }
    $stmt->close();
}


function consultarDatosPonderacion($id)
{
    global $conexion;
    $estado = false;
    $resultado = [];
    $consulta = "SELECT datos_ponderaciones.*,criterios.nombre,criterios.tipo, ponderaciones.ponderacion AS nombre_ponderacion FROM datos_ponderaciones INNER JOIN criterios ON criterios.id = datos_ponderaciones.id_criterios JOIN ponderaciones ON datos_ponderaciones.id_ponderacion = ponderaciones.id WHERE datos_ponderaciones.id_ponderacion = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("i", $id);
    if ($stmt) {
        if ($stmt->execute()) {
            $estado = true;
            $resultados = $stmt->get_result();
            while ($datos = $resultados->fetch_array()) {
                $resultado[] = $datos;
            }
        } else {
            $estado = $stmt->error;
        }
        $stmt->close();
        $conexion->close();
    } else {
        $estado = $conexion->error;
    }
    return array($estado, $resultado);
}

function consultarArea($area){
    global $conexion;
    $consulta = "SELECT id FROM areas
    WHERE nombre = '$area'";
    $query = $conexion->query($consulta);
    if ($query) {
        while ($datos = $query->fetch_array()) {
            $area = $datos;
        }
    }
    return $resultado;
}

function guardarNuevaPonderacion($nombre, $nuevaPonderacion,$area)
{
    global $conexion;
    //consultarArea($area);

    $consulta = "SELECT id FROM areas WHERE nombre = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("s", $area);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado) {
        $datos = $resultado->fetch_array();
        $idArea = $datos['id'];
    }
    //return $idArea;

    $insertar = "INSERT INTO ponderaciones (ponderacion,area) VALUES (?,?);";
    $stmt = $conexion->prepare($insertar);
    if (!$stmt) {
        return array($conexion->error);
    }
    $stmt->bind_param("si", $nombre,$idArea);
    if ($stmt->execute()) {
        $resultado = true;
        $ultimo_id = $conexion->insert_id;
        foreach ($nuevaPonderacion as $criterio => $parametros) {
            foreach ($parametros as $parametro => $valores) {
                $desde = $valores[0];
                $hasta = $valores[1];
                $puntos = $valores[2];
                if ($desde == '') {
                    $desde = null;
                }
                if ($hasta == '') {
                    $hasta = null;
                }
                if ($puntos == '') {
                    $puntos = null;
                }
                $insertar = "INSERT INTO datos_ponderaciones (id_ponderacion, id_criterios, parametro, desde, hasta, puntos) VALUES (?,?,?,?,?,?);"; //columna criterio por id_criterios
                $stmt = $conexion->prepare($insertar);
                $stmt->bind_param("issiii", $ultimo_id, $criterio, $parametro, $desde, $hasta, $puntos);
                if (!$stmt->execute()) {
                    $resultado = "No se inserto en datos_poderacion: " . $conexion->error;
                    // $conexion->rollback(); // Revertir transacción si falla la segunda inserción
                }
            }
        }
    } else {
        $resultado = "No se inserto en poderacion: " . $conexion->error;
    }
    return array($resultado, $ultimo_id);
}

function actualizarNuevoNombre($nombre, $id)
{
    global $conexion;
    $actualizar = "UPDATE ponderaciones SET ponderacion = ? WHERE id = ?";
    $stmt = $conexion->prepare($actualizar);
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param("si", $nombre, $id);
    if ($stmt->execute()) {
        return true;
    } else {
        return $stmt->error;
    }
    $stmt->close();
}

function actualizarPonderacion($id, $valores, $columna)
{
    global $conexion;
    $estado = false;
    $update = "UPDATE datos_ponderaciones SET $columna=? WHERE id=?";
    $stmt = $conexion->prepare($update);
    $stmt->bind_param("di", $valores, $id);
    if ($stmt->execute()) {
        $estado = true;
    }
    $stmt->close();
    return $estado;
}

function eliminarPonderacion($id)
{
    global $conexion;
    $estado = false;
    $delete = "DELETE FROM ponderaciones WHERE id=?";
    $stmt = $conexion->prepare($delete);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $estado = true;
        }
        $stmt->close();
        return $estado;
    } else {
        $conexion->error;
    }
}
