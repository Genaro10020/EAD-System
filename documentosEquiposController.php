<?php
session_start();
header("Content-Type: application/json");

require_once "conexionGhoner.php";

$variables = json_decode(file_get_contents("php://input"), true);

if (isset($variables["accion"]) && $variables["accion"] === "ConsultarDocumentos") {
  
  $consulta = "SELECT 
                    e.id, 
                    e.planta, 
                    e.area, 
                    e.nombre_ead AS ead, 
                    k.nombre_indicador AS proyecto,
                    k.linea_base,
                    k.entitlement,
                    k.meta_calculada,
                    k.meta_retadora
                FROM equipos_ead e
                LEFT JOIN kpis_proyectos k ON e.id = k.id_equipo";

  
  $stmt = $conexion->prepare($consulta);

  if ($stmt) {
    if ($stmt->execute()) {
      $resultado = $stmt->get_result();
      $datos = [];
      while ($fila = $resultado->fetch_assoc()) {
        $datos[] = array(
            "id"       => $fila["id"],
            "planta"   => $fila["planta"] ?? "",
            "area"     => $fila["area"] ?? "",
            "equipo"   => $fila["ead"] ?? "",
            "proyecto" => $fila["proyecto"] ?? "",
            "lb"       => $fila["linea_base"] ?? "",
            "entidad"  => $fila["entitlement"] ?? "",
            "mc"       => $fila["meta_calculad"] ?? "",
            "mr"       => $fila["meta_retadora"] ?? ""
        );
      }
      echo json_encode([true, $datos]);
    } else {
      echo json_encode([false, "Error al ejecutar la consulta"]);
    }
    $stmt->close();
  } else {
    echo json_encode([false, "Error al preparar la consulta"]);
  }
}

?>