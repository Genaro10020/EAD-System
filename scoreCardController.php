<?php
session_start();
if (isset($_SESSION['nombre'])) {
    $arreglo = json_decode(file_get_contents('php://input'), true);
    header('Content-Type: application/json');
    include("scoreCardModel.php");
    $resultado = "";
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['id_equipo']) && isset($_GET['id_ponderacion']) && isset($_GET['anio']) && isset($_GET['mes'])) {
                $id_equipo = $_GET['id_equipo'];
                $id_ponderacion = $_GET['id_ponderacion'];
                $anio = $_GET['anio'];
                $mes = $_GET['mes'];
                $resultado = consultar($id_equipo, $id_ponderacion, $anio, $mes);
            } else {
                $resultado = "No llegaron las variables para la consulta";
            }

            break;
        case 'POST':
            if (isset($arreglo['id_equipo']) && isset($arreglo['id_ponderacion']) && isset($arreglo['id_criterio']) && isset($arreglo['input_valor_actual']) && isset($arreglo['puntos_obtenidos']) && isset($arreglo['input_ponderacion']) && isset($arreglo['anio']) && isset($arreglo['mes'])) {
                if($arreglo['accion'] == 'total'){
                    //$resultado = actualizarTotal($id_equipo, $id_ponderacion, $total);    
                    $resultado = 'llegue a total';
                }else if($arreglo['accion'] == 'guardarGeneral'){
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
                }
            } else {
                $resultado = "No llegaron todas las variables " . "id_equipo: " .
                    $arreglo['id_equipo'] . "id_ponderacion: " . $arreglo['id_ponderacion'] .
                    "id_criterio: " . $arreglo['id_criterio'] .
                    "input_valor_actual: " . $arreglo['input_valor_actual'] .
                    "puntos_obtenidos: " . $arreglo['puntos_obtenidos'] .
                    "input_ponderacion: " . $arreglo['input_ponderacion'] .
                    "anio: " . $arreglo['anio'] .
                    "mes: " . $arreglo['mes'];
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
} else {
    header("Location:index.php");
}
