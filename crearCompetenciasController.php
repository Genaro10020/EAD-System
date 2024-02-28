<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("crearCompetenciasModel.php");
        $accion = $arreglo['accion'];
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
                if(isset($arreglo['accion']) && $arreglo['accion']=='CrearForo'){
                    $nombre_foro = $arreglo['nombre_foro'];
                    $planta= $arreglo['planta'];
                    $area = $arreglo['area'];
                    //$ids_ead=json_encode($arreglo['ids_ead'],JSON_UNESCAPED_UNICODE);
                    //$ids_evaluadores=json_encode($arreglo['evaluadores'],JSON_UNESCAPED_UNICODE);
                    $ids_ead=$arreglo['ids_ead'];
                    $ids_evaluadores=$arreglo['evaluadores'];
                    $resultado = guardarForo($nombre_foro,$planta,$area,$ids_ead,$ids_evaluadores);
                }
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