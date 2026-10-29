<?php

include("conexionGhoner.php");

function consultarTodosImpactosAmbientales() {
    global $conexion;

    // Verificar conexión.
    if (!$conexion instanceof mysqli) {
        throw new Exception("La conexión a la base de datos no está disponible.");
    }

    // Consulta.
    $stmt = $conexion->prepare("
        SELECT id, id_equipo, nombre_indicador, diagrama, tipo, concepto, alcance, cantidad, um, co2, referencia
        FROM reportes_impactos_ambientales_proyectos
        ORDER BY id ASC
    ");
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $conexion->error);
    }

    // Ejecutar.
    if (!$stmt->execute()) {
        throw new Exception("Error al consultar los impactos ambientales: " . $stmt->error);
    }

    // Obtener resultados.
    $impactos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $impactos;
}

function consultarImpactosAmbientales($nombre_indicador, $id_equipo) {
    global $conexion;

    // Consulta.
    $stmt = $conexion->prepare("
        SELECT * FROM reportes_impactos_ambientales_proyectos
        WHERE nombre_indicador = ? AND id_equipo = ?
        ORDER BY id ASC
    ");
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $conexion->error);
    }

    // Ejecutar.
    $stmt->bind_param("si", $nombre_indicador, $id_equipo);
    if (!$stmt->execute()) {
        throw new Exception("Error al consultar los impactos: " . $stmt->error);
    }

    // Obtener resultados.
    $impactos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $impactos;
}

function guardarImpacto($datos) {
    global $conexion;

    // Conexión OTS y restaurar Ghonher.
    include("conexionOTS.php");
    $conexionOTS = $conexion;
    include("conexionGhoner.php");

    // Validar datos.
    if (!is_array($datos) || empty($datos)) {
        $conexionOTS->close();
        return ["status" => "error", "message" => "No se recibieron datos."];
    }

    $nombre_indicador = trim($datos['nombre_indicador'] ?? '');
    $id_equipo = $datos['id_equipo'] ?? '';
    $impactos = $datos['impactos'] ?? [];

    if ($nombre_indicador === '' || $id_equipo === '') {
        $conexionOTS->close();
        return ["status" => "error", "message" => "Faltan datos del indicador o del equipo."];
    }

    if (!is_array($impactos)) {
        $conexionOTS->close();
        return ["status" => "error", "message" => "Los impactos ambientales no tienen un formato válido."];
    }

    // Iniciar transacciones.
    $conexion->begin_transaction();
    $conexionOTS->begin_transaction();

    try {

        // Obtener IDs existentes.
        $stmtIds = $conexion->prepare("SELECT id FROM reportes_impactos_ambientales_proyectos WHERE nombre_indicador = ? AND id_equipo = ?");
        if (!$stmtIds) {
            throw new Exception("Error al preparar consulta de IDs: " . $conexion->error);
        }
        $stmtIds->bind_param("si", $nombre_indicador, $id_equipo);
        if (!$stmtIds->execute()) {
            throw new Exception("Error al consultar IDs existentes: " . $stmtIds->error);
        }

        $idsExistentes = [];
        $resultadoIds = $stmtIds->get_result();
        while ($fila = $resultadoIds->fetch_assoc()) {
            $idsExistentes[] = (int)$fila['id'];
        }
        $stmtIds->close();

        // Preparar UPDATE.
        $stmtUpdate = $conexion->prepare("UPDATE reportes_impactos_ambientales_proyectos SET
                diagrama = ?, tipo = ?, concepto = ?, alcance = ?, cantidad = ?,
                um = ?, co2 = ?, referencia = ?
            WHERE id = ? AND id_equipo = ? AND nombre_indicador = ?");
        if (!$stmtUpdate) {
            throw new Exception("Error al preparar UPDATE: " . $conexion->error);
        }

        // Preparar INSERT.
        $stmtInsert = $conexion->prepare("
            INSERT INTO reportes_impactos_ambientales_proyectos
            (id_equipo, nombre_indicador, diagrama, tipo, concepto, alcance, cantidad, um, co2, referencia)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        if (!$stmtInsert) {
            throw new Exception("Error al preparar INSERT: " . $conexion->error);
        }

        // Preparar consulta e INSERT en impacto_ambiental (OTS).
        $stmtOTS = $conexionOTS->prepare("SELECT id FROM impacto_ambiental WHERE nombre = ? AND unidad = ? LIMIT 1");
        if (!$stmtOTS) {
            throw new Exception("Error al preparar consulta OTS: " . $conexionOTS->error);
        }

        $stmtInsertOTS = $conexionOTS->prepare("INSERT INTO impacto_ambiental(nombre,unidad) VALUES (?, ?)");
        if (!$stmtInsertOTS) {
            throw new Exception("Error al preparar INSERT OTS: " . $conexionOTS->error);
        }

        // Recorrer impactos recibidos.
        $idsRecibidos = [];
        $cantidadInsertados = 0;
        $cantidadActualizados = 0;
        $cantidadOTSInsertados = 0;
        $datosPorId = [];
        $ordenIdsFinales = [];

        foreach ($impactos as $impacto) {

            $id = (isset($impacto['id']) && $impacto['id'] !== '' && $impacto['id'] !== null) ? (int)$impacto['id'] : null;
            $diagrama = $impacto['diagrama'] ?? '';
            $tipo = $impacto['tipo'] ?? '';
            $concepto = $impacto['concepto'] ?? '';
            $alcance = (isset($impacto['alcance']) && $impacto['alcance'] !== '') ? (int)$impacto['alcance'] : null;
            $cantidad = (isset($impacto['cantidad']) && $impacto['cantidad'] !== '') ? (float)$impacto['cantidad'] : null;
            $um = $impacto['um'] ?? '';
            $co2 = (isset($impacto['co2']) && $impacto['co2'] !== '') ? (float)$impacto['co2'] : null;
            $referencia = $impacto['referencia'] ?? '';

            // Registrar en impacto_ambiental de OTS.
            if (trim($concepto) !== '' && trim($um) !== '') {
                $nombreOTS = trim($concepto) . " (" . trim($um) . ")";

                $stmtOTS->bind_param("ss", $nombreOTS, $um);
                if (!$stmtOTS->execute()) {
                    throw new Exception("Error al verificar impacto ambiental OTS: " . $stmtOTS->error);
                }

                if ($stmtOTS->get_result()->num_rows === 0) {
                    $stmtInsertOTS->bind_param("ss", $nombreOTS, $um);
                    if (!$stmtInsertOTS->execute()) {
                        throw new Exception("Error al insertar impacto ambiental OTS: " . $stmtInsertOTS->error);
                    }
                    $cantidadOTSInsertados++;
                }
            }

            if ($id !== null) {
                // Actualizar.
                $idsRecibidos[] = $id;

                $stmtUpdate->bind_param(
                    "sssidsdsiis",
                    $diagrama, $tipo, $concepto, $alcance, $cantidad,
                    $um, $co2, $referencia,
                    $id, $id_equipo, $nombre_indicador
                );
                if (!$stmtUpdate->execute()) {
                    throw new Exception("Error al actualizar el impacto ID " . $id . ": " . $stmtUpdate->error);
                }

                $cantidadActualizados++;
                $idFinal = $id;
            } else {
                // Insertar.
                $stmtInsert->bind_param(
                    "issssidsds",
                    $id_equipo, $nombre_indicador, $diagrama, $tipo, $concepto,
                    $alcance, $cantidad, $um, $co2, $referencia
                );
                if (!$stmtInsert->execute()) {
                    throw new Exception("Error al insertar el impacto: " . $stmtInsert->error);
                }

                $cantidadInsertados++;
                $idFinal = (int)$stmtInsert->insert_id;
            }

            // Acumular para proyectos_creados.
            $datosPorId[$idFinal] = [
                'diagrama'   => $diagrama,
                'tipo'       => $tipo,
                'alcance'    => $alcance ?? 0,
                'cantidad'   => $cantidad ?? 0,
                'referencia' => $referencia
            ];
            $ordenIdsFinales[] = $idFinal;
        }

        // Eliminar impactos que ya no vienen del frontend.
        foreach ($idsExistentes as $idExistente) {
            if (!in_array($idExistente, $idsRecibidos, true)) {
                $stmtDelete = $conexion->prepare("
                    DELETE FROM reportes_impactos_ambientales_proyectos
                    WHERE id = ? AND id_equipo = ? AND nombre_indicador = ?
                ");
                if (!$stmtDelete) {
                    throw new Exception("Error al preparar DELETE: " . $conexion->error);
                }

                $stmtDelete->bind_param("iis", $idExistente, $id_equipo, $nombre_indicador);
                if (!$stmtDelete->execute()) {
                    throw new Exception("Error al eliminar el impacto ID " . $idExistente . ": " . $stmtDelete->error);
                }
                $stmtDelete->close();
            }
        }

        // Sincronizar proyectos_creados (OTS).
        $proyectosActualizados = 0;

        if (!empty($idsExistentes)) {

            $resProyectos = $conexionOTS->query("
                SELECT id, id_eads, diagrama_proceso, tipo, alcance, cantidad, referencia
                FROM proyectos_creados
                WHERE id_eads IS NOT NULL AND id_eads <> ''
            ");
            if (!$resProyectos) {
                throw new Exception("Error al consultar proyectos_creados OTS: " . $conexionOTS->error);
            }

            // Decodifica un JSON a arreglo de $n posiciones.
            $decodificar = function ($json, $n, $relleno) {
                $arr = json_decode((string)$json, true);
                $arr = is_array($arr) ? array_values($arr) : [];
                while (count($arr) < $n) {
                    $arr[] = $relleno;
                }
                return $arr;
            };

            $flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

            $stmtUpdateProyecto = $conexionOTS->prepare("
                UPDATE proyectos_creados SET
                    diagrama_proceso = ?, tipo = ?, alcance = ?,
                    cantidad = ?, referencia = ?, id_eads = ?
                WHERE id = ?
            ");
            if (!$stmtUpdateProyecto) {
                throw new Exception("Error al preparar UPDATE de proyectos_creados: " . $conexionOTS->error);
            }

            while ($p = $resProyectos->fetch_assoc()) {

                $idsProyecto = json_decode($p['id_eads'], true);
                if (!is_array($idsProyecto)) {
                    continue;
                }
                $idsProyecto = array_map('intval', array_values($idsProyecto));

                // Si no coincide ningún id, no se hace nada.
                if (count(array_intersect($idsProyecto, $idsExistentes)) === 0) {
                    continue;
                }

                $n = count($idsProyecto);
                $oDiagramas   = $decodificar($p['diagrama_proceso'], $n, '');
                $oTipos       = $decodificar($p['tipo'], $n, '');
                $oAlcances    = $decodificar($p['alcance'], $n, 0);
                $oCantidades  = $decodificar($p['cantidad'], $n, 0);
                $oReferencias = $decodificar($p['referencia'], $n, '');

                $nDiagramas = $nTipos = $nAlcances = $nCantidades = $nReferencias = $nIds = [];

                // Recorrer posiciones actuales del proyecto.
                foreach ($idsProyecto as $i => $idPos) {
                    if (in_array($idPos, $idsExistentes, true)) {
                        // Pertenece a este indicador: se actualiza si sigue vigente, si no se elimina.
                        if (isset($datosPorId[$idPos])) {
                            $d = $datosPorId[$idPos];
                            $nDiagramas[]   = $d['diagrama'];
                            $nTipos[]       = $d['tipo'];
                            $nAlcances[]    = $d['alcance'];
                            $nCantidades[]  = $d['cantidad'];
                            $nReferencias[] = $d['referencia'];
                            $nIds[]         = $idPos;
                        }
                    } else {
                        // Ajeno a este indicador: se conserva intacto.
                        $nDiagramas[]   = $oDiagramas[$i];
                        $nTipos[]       = $oTipos[$i];
                        $nAlcances[]    = $oAlcances[$i];
                        $nCantidades[]  = $oCantidades[$i];
                        $nReferencias[] = $oReferencias[$i];
                        $nIds[]         = $idPos;
                    }
                }

                // Agregar al final los IDs nuevos.
                foreach ($ordenIdsFinales as $idFinal) {
                    if (!in_array($idFinal, $nIds, true)) {
                        $d = $datosPorId[$idFinal];
                        $nDiagramas[]   = $d['diagrama'];
                        $nTipos[]       = $d['tipo'];
                        $nAlcances[]    = $d['alcance'];
                        $nCantidades[]  = $d['cantidad'];
                        $nReferencias[] = $d['referencia'];
                        $nIds[]         = $idFinal;
                    }
                }

                $jsonDiagramas   = json_encode($nDiagramas, $flags);
                $jsonTipos       = json_encode($nTipos, $flags);
                $jsonAlcances    = json_encode($nAlcances, $flags);
                $jsonCantidades  = json_encode($nCantidades, $flags);
                $jsonReferencias = json_encode($nReferencias, $flags);
                $jsonIdsEads     = json_encode($nIds, $flags);
                $idProyecto      = (int)$p['id'];

                $stmtUpdateProyecto->bind_param(
                    "ssssssi",
                    $jsonDiagramas, $jsonTipos, $jsonAlcances,
                    $jsonCantidades, $jsonReferencias, $jsonIdsEads,
                    $idProyecto
                );
                if (!$stmtUpdateProyecto->execute()) {
                    throw new Exception("Error al actualizar el proyecto OTS ID " . $idProyecto . ": " . $stmtUpdateProyecto->error);
                }

                $proyectosActualizados++;
            }

            $stmtUpdateProyecto->close();
        }

        // Cerrar statements.
        $stmtUpdate->close();
        $stmtInsert->close();
        $stmtOTS->close();
        $stmtInsertOTS->close();

        // Confirmar transacciones.
        $conexion->commit();
        $conexionOTS->commit();
        $conexionOTS->close();

        // Respuesta.
        return [
            "status" => "success",
            "message" => "Impactos ambientales sincronizados correctamente.",
            "insertados" => $cantidadInsertados,
            "actualizados" => $cantidadActualizados,
            "eliminados" => count(array_diff($idsExistentes, $idsRecibidos)),
            "impactos_ots_insertados" => $cantidadOTSInsertados,
            "proyectos_ots_actualizados" => $proyectosActualizados,
            "cantidad" => $cantidadInsertados + $cantidadActualizados
        ];

    } catch (Exception $e) {
        $conexion->rollback();
        if ($conexionOTS) {
            $conexionOTS->rollback();
            $conexionOTS->close();
        }
        return ["status" => "error", "message" => $e->getMessage()];
    }
}

function eliminarImpacto($datos) {
    global $conexion;

    $id = $datos['id'] ?? '';
    $id_equipo = $datos['id_equipo'] ?? '';
    $nombre_indicador = $datos['nombre_indicador'] ?? '';

    // Validar datos.
    if (empty($id) || empty($id_equipo) || empty($nombre_indicador)) {
        return ["status" => "error", "message" => "Faltan datos para eliminar el impacto ambiental."];
    }
    $id = (int)$id;

    // Conexión OTS y restaurar Ghonher.
    include("conexionOTS.php");
    $conexionOTS = $conexion;
    include("conexionGhoner.php");

    // Iniciar transacciones.
    $conexion->begin_transaction();
    $conexionOTS->begin_transaction();

    try {

        // Eliminar en reportes_impactos_ambientales_proyectos.
        $stmt = $conexion->prepare("
            DELETE FROM reportes_impactos_ambientales_proyectos
            WHERE id = ? AND id_equipo = ? AND nombre_indicador = ?
        ");
        if (!$stmt) {
            throw new Exception("Error al preparar la eliminación: " . $conexion->error);
        }

        $stmt->bind_param("iis", $id, $id_equipo, $nombre_indicador);
        if (!$stmt->execute()) {
            $error = $stmt->error;
            $stmt->close();
            throw new Exception("Error al eliminar el impacto: " . $error);
        }

        if ($stmt->affected_rows === 0) {
            $stmt->close();
            throw new Exception("No se encontró el impacto ambiental con ID " . $id . ".");
        }
        $stmt->close();

        // Actualizar proyectos_creados (OTS) que contengan el ID eliminado.
        $proyectosActualizados = 0;

        $resProyectos = $conexionOTS->query("
            SELECT id, id_eads, diagrama_proceso, tipo, alcance, cantidad, referencia
            FROM proyectos_creados
            WHERE id_eads IS NOT NULL AND id_eads <> ''
        ");
        if (!$resProyectos) {
            throw new Exception("Error al consultar proyectos_creados OTS: " . $conexionOTS->error);
        }

        // Decodifica un JSON a arreglo de $n posiciones.
        $decodificar = function ($json, $n, $relleno) {
            $arr = json_decode((string)$json, true);
            $arr = is_array($arr) ? array_values($arr) : [];
            while (count($arr) < $n) {
                $arr[] = $relleno;
            }
            return $arr;
        };

        $flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

        $stmtUpdateProyecto = $conexionOTS->prepare("
            UPDATE proyectos_creados SET
                diagrama_proceso = ?, tipo = ?, alcance = ?,
                cantidad = ?, referencia = ?, id_eads = ?
            WHERE id = ?
        ");
        if (!$stmtUpdateProyecto) {
            throw new Exception("Error al preparar UPDATE de proyectos_creados: " . $conexionOTS->error);
        }

        while ($p = $resProyectos->fetch_assoc()) {

            $idsProyecto = json_decode($p['id_eads'], true);
            if (!is_array($idsProyecto)) {
                continue;
            }
            $idsProyecto = array_map('intval', array_values($idsProyecto));

            // Si el ID eliminado no está en este proyecto, no se hace nada.
            if (!in_array($id, $idsProyecto, true)) {
                continue;
            }

            $n = count($idsProyecto);
            $oDiagramas   = $decodificar($p['diagrama_proceso'], $n, '');
            $oTipos       = $decodificar($p['tipo'], $n, '');
            $oAlcances    = $decodificar($p['alcance'], $n, 0);
            $oCantidades  = $decodificar($p['cantidad'], $n, 0);
            $oReferencias = $decodificar($p['referencia'], $n, '');

            $nDiagramas = $nTipos = $nAlcances = $nCantidades = $nReferencias = $nIds = [];

            // Conservar todas las posiciones excepto la del ID eliminado.
            foreach ($idsProyecto as $i => $idPos) {
                if ($idPos === $id) {
                    continue;
                }
                $nDiagramas[]   = $oDiagramas[$i];
                $nTipos[]       = $oTipos[$i];
                $nAlcances[]    = $oAlcances[$i];
                $nCantidades[]  = $oCantidades[$i];
                $nReferencias[] = $oReferencias[$i];
                $nIds[]         = $idPos;
            }

            $jsonDiagramas   = json_encode($nDiagramas, $flags);
            $jsonTipos       = json_encode($nTipos, $flags);
            $jsonAlcances    = json_encode($nAlcances, $flags);
            $jsonCantidades  = json_encode($nCantidades, $flags);
            $jsonReferencias = json_encode($nReferencias, $flags);
            $jsonIdsEads     = json_encode($nIds, $flags);
            $idProyecto      = (int)$p['id'];

            $stmtUpdateProyecto->bind_param(
                "ssssssi",
                $jsonDiagramas, $jsonTipos, $jsonAlcances,
                $jsonCantidades, $jsonReferencias, $jsonIdsEads,
                $idProyecto
            );
            if (!$stmtUpdateProyecto->execute()) {
                throw new Exception("Error al actualizar el proyecto OTS ID " . $idProyecto . ": " . $stmtUpdateProyecto->error);
            }

            $proyectosActualizados++;
        }

        $stmtUpdateProyecto->close();

        // Confirmar transacciones.
        $conexion->commit();
        $conexionOTS->commit();
        $conexionOTS->close();

        // Respuesta.
        return [
            "status" => "success",
            "message" => "Impacto ambiental eliminado correctamente.",
            "id" => $id,
            "proyectos_ots_actualizados" => $proyectosActualizados
        ];

    } catch (Exception $e) {
        $conexion->rollback();
        if ($conexionOTS) {
            $conexionOTS->rollback();
            $conexionOTS->close();
        }
        return ["status" => "error", "message" => $e->getMessage()];
    }
}