<?php
    session_start();

    if(isset($_SESSION['nombre'])) {
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');

        include("impactosAmbientalesModel.php");

        $resultado = "";

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                break;
            
            case 'POST':
                if(!empty($arreglo)) {
                    $resultado = guardarImpacto($arreglo);
                } else {
                    $resultado = ["status" => "error", "message" => "No se recibieron datos."];
                }
                break;
            
            case 'PUT':
                break;
            
            case 'DELETE':
                break;
        }

        echo json_decode($resultado);
    } else {
        header("Location:index.php");
    }

?>