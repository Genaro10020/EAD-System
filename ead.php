<?php

 $variables = json_decode(file_get_contents('php://input'), true);
 header('Content-Type: application/json');
 include("conexionGhoner.php");
 $query = "INSERT INTO equipos_ead () VALUES() ";
 $query = $conexionGhoner->query($query);

 $nombre = $variables['nombre'];
 $planta = $variables['planta'];
 $area = $variables['area'];
 $proceso = $variables['proceso'];
 $lider_equipo = $variables['lider'];
 $coordinador = $variables['coordinador'];
 $jefe_area= $variables['jefe_area'];
 $ing_proceso = $variables['ing_proceso'];
 $ing_calidad = $variables['ing_calidad'];
 $supervisorvisor = $variables['supervisor'];


$respuesta="VENGO DESDE EL PHP";
 echo json_encode($respuesta);

?>