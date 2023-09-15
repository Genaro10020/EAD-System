<?php
session_start();
$arreglo = json_decode(file_get_contents('php://input'), true);
include("conexionGhoner.php");
header('Content-Type: application/json');


$resultado = [];
  
    //Verificar SI existe usuario
   
$consulta = "SELECT * FROM plantas_ead";
$query = $conexion->query($consulta);
if (mysqli_num_rows($query) > 0) {
    $resultado['Plantas'] = array();
    while ($dato = mysqli_fetch_array($query)) {
        $resultado['Plantas'][] = $dato;
    }
}

$consulta = "SELECT * FROM areas_ead";
$query = $conexion->query($consulta);
if (mysqli_num_rows($query) > 0) {
    $resultado['Areas'] = array();
    while ($dato = mysqli_fetch_array($query)) {
        $resultado['Areas'][] = $dato;
    }
}

$consulta = "SELECT * FROM subareas_ead";
$query = $conexion->query($consulta);
if (mysqli_num_rows($query) > 0) {
    $resultado['Subareas'] = array();
    while ($dato = mysqli_fetch_array($query)) {
        $resultado['Subareas'][] = $dato;
    }
}

$consulta = "SELECT * FROM tipo_usuario_ead";
$query = $conexion->query($consulta);
if (mysqli_num_rows($query) > 0) {
    $resultado['TiposUsuario'] = array();
    while ($dato = mysqli_fetch_array($query)) {
        $resultado['TiposUsuario'][] = $dato['tipo_usuario'];
    }
}


$consulta = "SELECT * FROM usuarios_ead ORDER BY id DESC ";
$query = $conexion ->query($consulta);
if(mysqli_num_rows($query) > 0){
    $resultado['Usuarios'] = array();
    while($dato = mysqli_fetch_array($query)){
        $resultado['Usuarios'][] = $dato;
    }
}
     
   

echo json_encode($resultado);
?>