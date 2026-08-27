<?php

session_start();

if (isset($_SESSION['nombre'])) {

    header('Content-Type: application/json; charset=utf-8');
    // Obtener datos enviados desde Vue/Axios
    $arreglo = json_decode(file_get_contents('php://input'), true);
    include("impactosAmbientalesModel.php");
    $resultado = null;
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $resultado = [
                "status" => "error",
                "message" => "Método GET no implementado."
            ];
            break;
        case 'POST':
            if (!empty($arreglo) &&is_array($arreglo) ) {
                // En este punto $arreglo contiene
                // uno o muchos impactos ambientales
                $resultado = guardarImpacto($arreglo);
            } else {
                $resultado = [
                    "status" => "error",
                    "message" => "No se recibieron datos."
                ];
            }
            break;
        case 'PUT':
            $resultado = [
                "status" => "error",
                "message" => "Método PUT no implementado."
            ];
            break;
        case 'DELETE':
            $resultado = [
                "status" => "error",
                "message" => "Método DELETE no implementado."
            ];
            break;

        default:
            $resultado = [
                "status" => "error",
                "message" => "Método HTTP no permitido."
            ];
            break;
    }

    // Regresar respuesta JSON
    echo json_encode($resultado);

} else {
    header("Location:index.php");
    exit;

}

?>