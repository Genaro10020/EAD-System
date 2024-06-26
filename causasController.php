<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("causasModel.php");
        $resultado = "";  
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                if($_GET['grafica'] && $_GET['id_equipo'] && $_GET['anio'] && $_GET['mes']){
                    $grafica = $_GET['grafica'];
                    $id_equipo = $_GET['id_equipo'];
                    $anio = $_GET['anio'];
                    $mes = $_GET['mes'];
                    $resultado = consultarCausas($grafica,$id_equipo,$anio,$mes);
                }else{
                    $resultado = "No llegaron todos los parametros en GET";
                }
                break;
            case 'POST':
                    $tabla= $arreglo['tabla'];
                    $id_equipo = $arreglo['id_equipo'];
                    $equipo = $arreglo['equipo'];
                    $responsable =$arreglo['responsable'];
                    $causa = $arreglo['causa'];
                    $anio = $arreglo['anio'];
                    $mes = $arreglo['mes'];
                    $dia = $arreglo['dia'];
                    $resultado = guardarCausa($tabla,$id_equipo,$equipo,$responsable,$causa,$anio,$mes,$dia);
                break;
            case 'PUT':
                    $id =$arreglo['id'];
                    $responsable =$arreglo['responsable'];
                    $causa = $arreglo['causa'];
                    $dia = $arreglo['dia'];
                    $resultado = actualizarCausa($id,$responsable,$causa,$dia);
                break;
            case 'DELETE':
                    $id = $_GET['id'];
                    $resultado = eliminarCausa($id);
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