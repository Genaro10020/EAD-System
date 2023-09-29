<?php
session_start();
$arreglo = json_decode(file_get_contents('php://input'), true);
include("conexionGhoner.php");
header('Content-Type: application/json');

$id=$arreglo['id'];
$resultado = [];
  
$consulta = "SELECT * FROM usuarios WHERE id='$id'";
$query = $conexion ->query($consulta);

   if($fila = mysqli_fetch_assoc($query)){
        $resultado = $fila;
    }

    

echo json_encode($resultado);
?>