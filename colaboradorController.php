<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("colaboradorModel.php");
        $resultado = "";  
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
             
                break;
            case 'POST':
                   if(isset($arreglo['nombre']) && isset($arreglo['nomina']) && isset($arreglo['planta'])){
                    $nombre = $arreglo['nombre'];
                    $nomina = $arreglo['nomina'];
                    $password = '123456';
                    $planta = $arreglo['planta'];
                    $resultado = insertarColaborador($nombre,$nomina,$password,$planta);
                   }else{
                    $resultado = "Faltan datos";
                   }
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