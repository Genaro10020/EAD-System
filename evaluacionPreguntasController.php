<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("evaluacionPreguntasModel.php");
        $resultado = "";  
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                if(isset($_GET['accion']) && $_GET['accion']=='preguntasEvaluador'){
                    $id_ead_foro=$_GET['id_ead_foro'];
                    $idEvaluador = $_SESSION['id'];
                    $resultado = consultarPreguntasEvaluador($idEvaluador, $id_ead_foro); 
                }
                break;
            case 'POST':
                if(isset($arreglo['id_pregunta']) && isset($arreglo['id_ead_foro']) && isset($arreglo['valor'])){
                    $id_pregunta= $arreglo['id_pregunta']; 
                    $id_ead_foro=$arreglo['id_ead_foro'];
                    $valor=$arreglo['valor'];
                    $id_evaluador = $_SESSION['id'];
                    $resultado = actualizarValor($id_pregunta,$id_evaluador,$id_ead_foro,$valor);
                }else{
                    $resultado = "No se encuentran las variebles en el controlador";
                }
                break;
            case 'PUT':
                if(isset($arreglo['id_calificacion']) && isset($arreglo['calificacionEAD'])){
                    $id_calificacion=$arreglo['id_calificacion'];
                    $calificacionEAD= $arreglo['calificacionEAD'];
                    $comentario= $arreglo['comentario'];
                    $resultado = actualizarCalifacionEAD($id_calificacion,$calificacionEAD,$comentario);
                }else{
                    $resultado = "No existen las variables de calificacion";
                }
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