<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        $resultado = [];
        $tipo_usuario = $_SESSION['tipo_acceso'];

       if(isset($_SESSION['tipo_acceso'])){
        $resultado[] =  $_SESSION['tipo_acceso'];
       }
        echo json_encode($resultado);
}else{
    header("Location:index.php");
}
?>