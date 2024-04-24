<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("compromisoModel.php");
       
        $accion = "";
        $resultado = "";  
        if(isset($arreglo['accion'])){
            $accion = $arreglo['accion'];
        }
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                    if(isset($_GET['accion']) && isset($_GET['id_equipo']) &&  $_GET['accion']==='Consultar'){
                        $id_equipo=$_GET['id_equipo'];
                        $resultado = consultarCompromisos($id_equipo);
                    }
                break;
            case 'POST':
                    if(isset($arreglo['id_equipo']) && isset($arreglo['compromiso']) && isset($arreglo['responsable']) && isset($arreglo['fecha'])){
                        $id_equipo=$arreglo['id_equipo'];
                        $compromiso=$arreglo['compromiso'];
                        $responsable=$arreglo['responsable'];
                        $fecha=$arreglo['fecha'];
                        $resultado = guardarCompromiso($id_equipo,$fecha,$compromiso,$responsable);
                    }else{
                        $resultado = "No llegaron las variables para insertar";
                    }  
                break;
            case 'PUT':
                if($accion=='Actualizar Compromiso'){
                    if(isset($arreglo['id_compromiso']) && isset($arreglo['compromiso']) && isset($arreglo['responsable']) && isset($arreglo['fecha'])){
                        $id_compromiso=$arreglo['id_compromiso'];
                        $fecha=$arreglo['fecha'];
                        $compromiso=$arreglo['compromiso'];
                        $responsable=$arreglo['responsable'];
                        $resultado = actualizarCompromiso($id_compromiso,$fecha,$compromiso,$responsable);
                    }else{
                        $resultado = "No llegaron las variables para actualizar";
                    }  
                }else if($accion=='Actualizar Porcentaje'){
                    if(isset($arreglo['compromiso_id']) && isset($arreglo['porcentaje'])){
                    $compromiso_id= $arreglo['compromiso_id'];
                    $porcentaje = $arreglo['porcentaje'];
                    $resultado = actualizarPorcentaje($compromiso_id,$porcentaje);
                    }else{
                        $resultado = "No llegaron todas las variables de porcentaje".$arreglo['compromiso_id'].$arreglo['porcentaje'].$accion;
                    }
                }else{
                    $resultado = "No exite esa opcion en POST";
                }
                break;
            case 'DELETE':
                    if(isset($_GET['id_compromiso'])){
                        $id_compromiso = $_GET['id_compromiso'];
                        $resultado = eliminarCompromiso($id_compromiso);
                    }else{
                        $resultado = "No llego la variable para eliminar";
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