<?php
session_start();
if (isset($_SESSION['nombre'])) {
    $arreglo = json_decode(file_get_contents('php://input'), true);
    include("conexionGhoner.php");
    header('Content-Type: application/json');
    $accion = $arreglo['accion'];
    $resultado = "";
    switch ($accion) {
        case 'insertar':
            $nombre = $arreglo['nombre'];
            $planta = $arreglo['planta'];
            $area = $arreglo['area'];
            $proceso = $arreglo['proceso'];
            $lider_equipo = $arreglo['lider'];
            $coordinador = $arreglo['coordinador'];
            $jefe_area = $arreglo['jefe_area'];
            $ing_proceso = $arreglo['ing_proceso'];
            $ing_calidad = $arreglo['ing_calidad'];
            $supervisor = $arreglo['supervisor'];
            /*$insertar = "INSERT INTO tipo_usuario (tipo_usuario) VALUES ('$nuevo')";
            $query = $conexion->query($insertar);
            if ($query) {
                $resultado = $query;
            }*/
            $insertar = "INSERT INTO equipos_ead (nombre_ead,planta,area,proceso,lider_equipo,coordinador,jefe_area,ing_procesos,ing_calidad,supervisor)
                                                  VALUES (?,?,?,?,?,?,?,?,?,?)";
            $stmt = $conexion->prepare($insertar);
            if ($stmt === false) {
                $resultado = "Error en Bind" . $conexion->error;
            } else {
                $stmt->bind_param("ssssssssss", $nombre, $planta, $area, $proceso, $lider_equipo, $coordinador, $jefe_area, $ing_proceso, $ing_calidad, $supervisor);
                if ($stmt->execute()) {
                    $resultado = true;
                } else {
                    $resultado = "Error en Bind" . $stmt->error;
                }
                $stmt->close();
            }
            break;
        case 'eliminar':
            $usuario = $arreglo['usuario'];
            $delete = "DELETE FROM tipo_usuario WHERE tipo_usuario='$usuario'";
            $query = $conexion->query($delete);
            if ($query) {
                $resultado = $query;
            }
            break;

        default:
            # code...
            break;
    }
    echo json_encode($resultado);
} else {
    header("Location:index.php");
}
