<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("cumplimientoProyectosModel.php");
        $resultado = "";  


        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
               

                break;
            case 'POST':
                 if (isset($arreglo['area']) && isset( $arreglo['anio'])  && isset($arreglo['idsEquipos'])  && isset($arreglo['accion'])  && $arreglo['accion']==="Consultar"){
                    $area = $arreglo['area'];
                    $anio = $arreglo['anio'];
                    $idsEquipos = $arreglo['idsEquipos'];
                    $resultado = consultarProyectos($area, $anio, $idsEquipos);
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