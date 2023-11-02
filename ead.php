<?php
 $variables = json_decode(file_get_contents('php://input'), true);
 header('Content-Type: application/json');
 include("conexionGhoner.php");


 $nombre = $variables['nombre'];
 $planta = $variables['planta'];
 $area = $variables['area'];
 $proceso = $variables['proceso'];
 $lider_equipo = $variables['lider_equipo'];
 $coordinador = $variables['coordinador'];
 $jefe_area= $variables['jefe_area'];
 $ing_proceso = $variables['ing_proceso'];
 $ing_calidad = $variables['ing_calidad'];
 $supervisorvisor = $variables['supervisorvisor'];




$respuesta="VENGO DESDE EL PHP";
 echo json_encode($respuesta);

?>