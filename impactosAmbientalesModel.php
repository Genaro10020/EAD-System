<?php

include("conexionGhoner.php");


function guardarImpacto($datos) {

    global $conexion;


    // Verificar que sea un arreglo
    if (!is_array($datos) || empty($datos)) {

        return [
            "status" => "error",
            "message" => "No se recibieron datos."
        ];

    }


    // Recuperar datos generales
    $nombre_indicador = $datos['nombre_indicador'] ?? '';
    $id_equipo = $datos['id_equipo'] ?? '';


    // Recuperar impactos
    $impactos = $datos['impactos'] ?? [];


    // Verificar que existan impactos
    if (empty($impactos)) {

        return [
            "status" => "error",
            "message" => "No se recibieron impactos ambientales."
        ];

    }


    // Iniciar transacción
    $conexion->begin_transaction();


    try {

        $guardar = "
            INSERT INTO reportes_impactos_ambientales_proyectos
            (
                id_equipo,
                nombre_indicador,
                diagrama,
                tipo,
                concepto,
                alcance,
                cantidad,
                um,
                co2,
                referencia
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";


        $stmt = $conexion->prepare($guardar);


        if (!$stmt) {

            throw new Exception(
                "Error al preparar la consulta: " . $conexion->error
            );

        }


        $cantidadGuardada = 0;


        // Recorrer todos los impactos
        foreach ($impactos as $impacto) {


            $diagrama = $impacto['diagrama'] ?? '';

            $tipo = $impacto['tipo'] ?? '';

            $concepto = $impacto['concepto'] ?? '';


            $alcance = (
                isset($impacto['alcance']) &&
                $impacto['alcance'] !== ''
            )
                ? (int)$impacto['alcance']
                : null;


            $cantidad = (
                isset($impacto['cantidad']) &&
                $impacto['cantidad'] !== ''
            )
                ? (float)$impacto['cantidad']
                : null;


            $um = $impacto['um'] ?? '';


            $co2 = (
                isset($impacto['co2']) &&
                $impacto['co2'] !== ''
            )
                ? (float)$impacto['co2']
                : null;


            $referencia = $impacto['referencia'] ?? '';


            // Vincular parámetros
            $stmt->bind_param(
                "issssidsds",
                $id_equipo,
                $nombre_indicador,
                $diagrama,
                $tipo,
                $concepto,
                $alcance,
                $cantidad,
                $um,
                $co2,
                $referencia
            );


            // Ejecutar INSERT
            if (!$stmt->execute()) {

                throw new Exception(
                    "Error al guardar el impacto: " . $stmt->error
                );

            }


            $cantidadGuardada++;

        }


        // Confirmar todos los INSERT
        $conexion->commit();


        // Cerrar statement
        $stmt->close();


        return [
            "status" => "success",
            "message" => "Impactos ambientales guardados correctamente.",
            "cantidad" => $cantidadGuardada
        ];


    } catch (Exception $e) {


        // Deshacer todos los INSERT
        $conexion->rollback();


        return [
            "status" => "error",
            "message" => $e->getMessage()
        ];

    }

}

?>