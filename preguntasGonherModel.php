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

?>