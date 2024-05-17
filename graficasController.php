<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("graficasModel.php");
        $resultado = "";  
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                if($_GET['grafica'] && $_GET['id_equipo'] && $_GET['anio'] && $_GET['mes']){
                    $grafica = $_GET['grafica'];
                    $id_equipo = $_GET['id_equipo'];
                    $anio = $_GET['anio'];
                    $mes = $_GET['mes'];
                    $resultado = consultarDatosGrafica($grafica,$id_equipo,$anio,$mes);
                }else{
                    $resultado = "No llego el ID del equipo";
                }
                break;
            case 'POST':
                if(isset($arreglo['planta']) && isset($arreglo['area']) && isset($arreglo['id_equipo']) && isset($arreglo['nombre_ead']) && isset($arreglo['grafica']) && isset($arreglo['anio']) && isset($arreglo['mes']) && isset($arreglo['dia'])){
                    $planta=$arreglo['planta'];
                    $area = $arreglo['area'];
                    $id_equipo = $arreglo['id_equipo'];
                    $nombre_ead = $arreglo['nombre_ead'];
                    $grafica = $arreglo['grafica'];
                    $anio = $arreglo['anio'];
                    $mes = $arreglo['mes'];
                    $dia = $arreglo['dia'];
                    $valor = $arreglo['valor'];
                    $resultado = guardarDatosGrafica($planta,$area,$id_equipo,$nombre_ead,$grafica,$anio,$mes,$dia,$valor);
                }else{
                    $resultado = "No llegaron todas las variables";
                }
                break;
            case 'PUT':
    
                break;
            case 'DELETE':

                break;
        default:
            //http_response_code(405); // Método no permitido
            $resultado = "Método HTTP no permitido";
        break;
        }
        echo json_encode($resultado);
}else{
    header("Location:index.php");
}
?>