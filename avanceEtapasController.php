<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("avanceEtapasModel.php");
        $resultado = "";  
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                if (isset($_GET['accion']) && isset($_GET['metodologia']) && $_GET['accion']==="Consultar"){
                    $metodologia = $_GET['metodologia'];
                    $resultado = consultarEtapas($metodologia);
                }
                break;
            case 'POST':
                   
                break;
            case 'PUT':
    
                break;
            case 'DELETE':

                break;
        default:
        $resultado = "Método HTTP no permitido";
        //http_response_code(405); // Método no permitido
        break;
        }
        echo json_encode($resultado);
}else{
    header("Location:index.php");
}
?>