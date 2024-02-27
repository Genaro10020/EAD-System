<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("crearCompetenciasModel.php");
        $accion = $arreglo['accion'];
        $nuevo = $arreglo['nuevo_tipo'];
        $resultado = "";  
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                if(isset($_GET['accion']) && $_GET['accion']=='Filtrar'){
                   $planta= $_GET['planta']; 
                   $area= $_GET['area'];
                        $resultado = consultarEADxPlantaxArea($planta,$area);
                }
               
                break;
            case 'POST':

                break;
            case 'PUT':

                break;
            case 'DELETE':

                break;
        default:
        $val = "Método HTTP no permitido";
        //http_response_code(405); // Método no permitido
        break;
        }
        echo json_encode($resultado);
}else{
    header("Location:index.php");
}
?>