<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("criteriosModel.php");
        $resultado = "";  
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                    if(isset($_GET['accion']) && $_GET['accion'] =='Consultar'){
                        $resultado = consultarCriterios();
                    }else if(isset($_GET['accion']) && $_GET['accion'] =='consultarCriterios'){
                        $id_equipo = $_GET['id_equipo'];
                        $resultado = consultarCriteriosPonderacion($id_equipo);
                    }else if(isset($_GET['accion']) && $_GET['accion'] =='consultarCriterioColaborador'){
                        $id_equipo = $_GET['id_equipo'];
                        $id_criterio = $_SESSION['id_tabla'];
                        $resultado = consultarCriteriosColaborador($id_equipo,$id_criterio);
                    }else{
                        $resultado = "No se ha seleccionado una acción válida";
                    }
                break;
            case 'POST':
                   
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