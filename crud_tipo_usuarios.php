<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        include("conexionGhoner.php");
        header('Content-Type: application/json');
        $accion = $arreglo['accion'];
        $nuevo = $arreglo['nuevo_tipo'];

        $resultado = "";  

        switch ($accion) {
        case 'insertar':
        $insertar = "INSERT INTO tipo_usuario (tipo_usuario) VALUES ('$nuevo')";
        $query=$conexion->query($insertar);
        if($query){
            $resultado = $query;
        }
        break;
        case 'eliminar':
            $usuario = $arreglo['usuario'];
            $delete = "DELETE FROM tipo_usuario WHERE tipo_usuario='$usuario'";
            $query=$conexion->query($delete);
            if($query){
                $resultado = $query;
            }
            break;

        default:
        # code...
        break;
        }


        echo json_encode($resultado);
}else{
    header("Location:index.php");
}
?>