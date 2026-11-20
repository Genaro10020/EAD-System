<?php
include("conexionGhoner.php");

function validarNombreTabla($tabla) {
  $tablasPermitidas = ["preguntas", "preguntas_gonher"];

  return is_array($tabla, $tablasPermitidas, true) ? $tabla : false;
}

function consultarPreguntas($tabla) {
  global $conexion;

  $tablaSegura = validarNombreTabla($tabla);

  if (!$tablaSegura) {
    return array("Tabla no válida", []);
  }

  $resultado = [];

  $consulta = "SELECT id, id_ead_foro, etapa, peso, pregunta, valor
                FROM `$tablaSegura`
                WHERE id_ead_foro = 0
                ORDER BY id ASC";
  
  $stmt = $conexion->prepare($consulta);

  if (!$stmt->execute()) {
    $error = "Error al ejecutar: " . $stmt->error;
    $stmt->close();

    return array($error, $resultado);
  }

  $datos = $stmt->get_result();
  while ($fila = $datos->fetch_assoc()) {
    $resultado[] = $fila;
  }

  $stmt->close();
  $conexion->close();

  return array(true, $resultado);
}

function insertarPregunta($tabla, $etapa, $peso, $pregunta) {
  global $conexion;

  $tablaSegura = validarNombreTabla($tabla);

  if (!$tablaSegura) {
    return "Tabla no válida";
  }

  $id_ead_foro = 0;
  $valor = 0;

  $insertar = "INSERT INTO `$tablaSegura` (id_ead_foro, etapa, peso, pregunta, valor) VALUES (?, ?, ?, ?, ?)";

  $stmt = $conexion->prepare($insertar);

  if (!$stmt) {
    return "Error al preparar: " . $conexion->error;
  }

  $stmt->bind_param("isisi", $id_ead_foro, $etapa, $peso, $pregunta, $valor);

  if ($stmt->execute()) {
    $stmt->close();
    sincronizarPesoEtapa($tablaSegura, $etapa, $peso);
    $conexion->close();

    return true;
  } else {
    $error = $stmt->error;
    $stmt->close();
    $conexion->close();

    return $error;
  }
}

function actualizarPregunta($tabla, $id, $etapa, $peso, $pregunta) {
  global $conexion;

  $tablaSegura = validarNombreTabla($tabla);

  if (!$tablaSegura) {
    return "Tabla no válida";
  }

  $actualizar = "UPDATE `$tablaSegura` SET etapa = ?, peso = ?, pregunta = ? WHERE id = ? AND id_ead_foro = 0";

  $stmt = $conexion->prepare($actualizar);

  if (!$stmt) {
    return "Error al preparar: " . $conexion->error;
  }

  $stmt->bind_param("sisi", $etapa, $peso, $pregunta, $id);

  if ($stmt->execute()) {
    $stmt->close();
    sincronizarPesoEtapa($tablaSegura, $etapa, $peso);

    $conexion->close();

    return true;
  } else {
    $error = $stmt->error;

    $stmt->close();
    $conexion->close();

    return $error;
  }
}

?>