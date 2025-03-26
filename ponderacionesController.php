<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("ponderacionesModel.php");
        $resultado = "";  
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                    if(isset($_GET['accion']) && $_GET['accion']=='datosPonderacionXID' && isset($_GET['id_ponderacion'])){
                        $id = $_GET['id_ponderacion'];
                        $resultado = consultarDatosPonderacion($id);
                    }else if(isset($_GET['accion']) && $_GET['accion']=='nombrePonderaciones'){
                        $resultado = consultarTablaPonderaciones();
                    }else if(isset($_GET['accion']) && $_GET['accion']=='consultarPonderaciones') {
                        $area = $_SESSION['area'];
                        $tipo_usuario = $_SESSION['tipo_usuario'];
                        $resultado = consultarPonderacion($area,$tipo_usuario);
                    }else{
                        $resultado = "No se ha seleccionado ninguna acción: ".$_GET['accion'];
                    }
                break;
            case 'POST':
                    $nombre_ponderacion = $arreglo['nombre_ponderacion'];
                    $nuevaPonderacion = $arreglo['nuevaPonderacion'];
                    $area = $_SESSION['area'];
                    $resultado = guardarNuevaPonderacion($nombre_ponderacion,$nuevaPonderacion,$area);   
                break;
            case 'PUT':
                if (isset($arreglo['nuevo']) && isset($arreglo['id_ponderacion'])) {
                    $nombre=$arreglo['nuevo'];
                    $id=$arreglo['id_ponderacion'];
                    $resultado = actualizarNuevoNombre($nombre,$id);

                }else if(isset($arreglo['accion']) && $arreglo['accion']=="AsignarPonderacion"){
                    $id_ead=$arreglo['id_ead'];
                    $id_ponderacion=$arreglo['id_ponderacion'];
                    $resultado = actualizarAsignacion($id_ead,$id_ponderacion);

                }else if(isset($arreglo['accion']) && $arreglo['accion'] == "insertarArea"){
                    $nombre = $arreglo['area'];
                    $id = $arreglo['id'];
                    $resultado = insertarArea($nombre,$id);
                    
                }else {
                    $id= $arreglo['id'];
                    $valores = $arreglo['valor'];
                    $columna = $arreglo['columna'];
                    $resultado = actualizarPonderacion($id,$valores,$columna);
                }
                   break;
            case 'DELETE':
                    if(isset($_GET['id'])){
                        $id = $_GET['id'];
                        $resultado = eliminarPonderacion($id);
                    }else{
                        $resultado = "No existe la variable ID";
                    }
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