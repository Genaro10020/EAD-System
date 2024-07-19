<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("competenciasModel.php");
        //$accion = $arreglo['accion'];
        $resultado = "";  
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                            if(isset($_GET['accion']) && $_GET['accion']=='Consultar'){
                                    $resultado = consultarForos();
                            }
                            if(isset($_GET['accion']) && $_GET['accion']=='Filtrar'){
                            $planta= $_GET['planta']; 
                            $area= $_GET['area'];
                                    $resultado = consultarEADxPlantaxArea($planta,$area);
                            }
                            if(isset($_GET['accion']) && $_GET['accion']=='DetallesForo'){
                                $id= $_GET['id']; 
                                    $resultado = consultarDetallesForo($id);
                            }
                break;
            case 'POST':
                        if(isset($arreglo['accion']) && $arreglo['accion']=='CrearForo'){
                            $nombre_foro = $arreglo['nombre_foro'];
                            $planta= $arreglo['planta'];
                            $area = $arreglo['area'];
                            $fecha = $arreglo['fecha'];
                            //$ids_ead=json_encode($arreglo['ids_ead'],JSON_UNESCAPED_UNICODE);
                            //$ids_evaluadores=json_encode($arreglo['evaluadores'],JSON_UNESCAPED_UNICODE);
                            $ids_ead=$arreglo['ids_ead'];
                            $ids_evaluadores=$arreglo['evaluadores'];
                            $resultado = guardarForo($nombre_foro,$planta,$area,$fecha,$ids_ead,$ids_evaluadores);
                        }
                break;
            case 'PUT':
                        if(isset($arreglo['id_ead_foro']) && isset($arreglo['nombre_proyecto'])){
                            $id_ead_foro = $arreglo['id_ead_foro'];
                            $nombre_proyecto = $arreglo['nombre_proyecto'];
                            $resultado = actualizandoNombreProyecto($id_ead_foro,$nombre_proyecto);
                        }else{
                            $resultado = "No llegaron las variables";
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