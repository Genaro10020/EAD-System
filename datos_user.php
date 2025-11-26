<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        $resultado = [];
        //$tipo_usuario = $_SESSION['tipo_acceso'];

        if(isset($_SESSION['tipo_usuario'])){ // para comprobar usuarios en EAD
            $resultado[] =  $_SESSION['tipo_usuario'];
        }else if(isset($_SESSION['tipo_acceso']) && $_SESSION['tipo_acceso']=="Evaluador"){ //enfocado a Evaluadores
            $resultado[] =  $_SESSION['tipo_acceso'];
        }else if(isset($_SESSION['tipo_acceso']) && $_SESSION['tipo_acceso']=="Colaborador"){
            $resultado[] =  $_SESSION['tipo_acceso'];
        }if(isset($_SESSION['tipo_acceso']) && $_SESSION['tipo_acceso']=="ColaboradorLider"){
            $resultado[] =  $_SESSION['tipo_acceso'];
        }else{
            $resultado[] = "No existe ese tipo";
        }
        echo json_encode($resultado);
}else{
    header("Location:index.php");
}
?>