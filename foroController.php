<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("foroModel.php");
        $resultado = "";  
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
             
                break;
            case 'POST':
                   
                break;
            case 'PUT':
                    if(isset($arreglo['id_foro']) && isset($arreglo['nuevoEstatus'])){
                        $id_foro= $arreglo['id_foro'];
                        $nuevoEstatus= $arreglo['nuevoEstatus'];
                        $resultado= actualizarEstatus($id_foro,$nuevoEstatus);
                    }
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