<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("capacitacionesModel.php");
       
        $accion = "";
        $resultado = "";  
        if(isset($arreglo['accion'])){
            $accion = $arreglo['accion'];
        }
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                    if(isset($_GET['accion']) &&  $_GET['accion']==='Consultar'){
                        $area=$_SESSION['area'];
                        $resultado = consultarCapacitacion($area);
                    }else{
                        $resultado = "No me llegaron la variables."; 
                    }
                break;
            case 'POST':
                if(isset($arreglo['accion']) && $arreglo['accion']=='Nuevo'){
                        if(isset($arreglo['fecha_capacitacion']) && isset($arreglo['nuevos_ingresos']) && isset($arreglo['comentarios_capacitacion'])){
                            $area=$_SESSION['area'];
                            $fecha=$arreglo['fecha_capacitacion'];
                            $ingresos=$arreglo['nuevos_ingresos'];
                            $comentario=$arreglo['comentarios_capacitacion'];
                            $resultado = guardarCapacitacion($area,$fecha,$ingresos,$comentario);
                        }else{
                            $resultado = "No llegaron las variables para insertar";
                        }  
                }else if(isset($arreglo['accion']) && $arreglo['accion']=='Actualizar'){
                     if(isset($arreglo['id']) && isset($arreglo['fecha_capacitacion']) && isset($arreglo['nuevos_ingresos']) && isset($arreglo['comentarios_capacitacion'])){
                            $id=$arreglo['id'];
                            $fecha=$arreglo['fecha_capacitacion'];
                            $ingresos=$arreglo['nuevos_ingresos'];
                            $comentario=$arreglo['comentarios_capacitacion'];
                            $resultado = actualizarCapacitacion($id,$fecha,$ingresos,$comentario);
                        }else{
                            $resultado = "No llegaron las variables para insertar";
                        }  
                
                }else{
                     $resultado = "No reconozco esta acción";
                }

                    
                break;
            /*
            case 'PUT':
                if($accion=='Actualizar Capacitacion'){
                    if(isset($arreglo['comentario']) && isset($arreglo['fecha']) && isset($arreglo['ingresos'])){
                        $comentario=$arreglo['comentario'];
                        $fecha=$arreglo['fecha'];
                        $ingresos=$arreglo['ingresos'];
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
            *//////////////
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