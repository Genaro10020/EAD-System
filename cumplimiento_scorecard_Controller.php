<?php
session_start();
if (isset($_SESSION['nombre'])) {
    $arreglo = json_decode(file_get_contents('php://input'), true);
    header('Content-Type: application/json');
    include("cumplimiento_scorecard_Model.php");
    $resultado = "";
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':

            break;
        case 'POST':
                if($arreglo['accion'] == 'consultarCumplimientoScorecard'){
                    $area=$arreglo['area'];
                    $anio=$arreglo['anio'];
                    $resultado = consultarCumplimientoScorecard($area,$anio);    

                }/*else if($arreglo['accion'] == 'guardarGeneral'){
                    $id_equipo = $arreglo['id_equipo'];
                    $id_ponderacion = $arreglo['id_ponderacion'];
                    $id_criterio = $arreglo['id_criterio'];
                    $input_valor_actual = $arreglo['input_valor_actual'];
                    $puntos_obtenidos = $arreglo['puntos_obtenidos'];
                    $input_ponderacion = $arreglo['input_ponderacion'];
                    $anio = $arreglo['anio'];
                    $mes = $arreglo['mes'];
                    $total = $arreglo['total'];
                    $resultado = consultarInsertarActualizar($id_equipo, $id_ponderacion, $id_criterio, $input_valor_actual, $puntos_obtenidos, $input_ponderacion, $anio, $mes, $total);    
                }*/
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
} else {
    header("Location:index.php");
}
