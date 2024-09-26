<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("seguimientoKpiModel.php");
        $resultado = "";  
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                if(isset($_GET['id_equipo'])){
                    $id_equipo=$_GET['id_equipo'];
                    $resultado = consultar($id_equipo);
                }else{
                    $resultado = "No llego el ID del equipo para consultar";
                }
                break;
            case 'POST':
                    if(isset($arreglo['id_equipo']) && isset($arreglo['unidad']) && isset($arreglo['nombre_indicador']) && isset($arreglo['linea_base']) && isset($arreglo['entitlement']) && isset($arreglo['meta_calculada']) && isset($arreglo['meta_retadora']) && isset($arreglo['anio_kpi']) && isset($arreglo['semana_kpi']) && isset($arreglo['dato_semanal']) && isset($arreglo['mes_cierre'])){
                        $id_equipo=$arreglo['id_equipo'];
                        $unidad=$arreglo['unidad'];
                        $nombre=$arreglo['nombre_indicador'];
                        $linea_base=$arreglo['linea_base'];
                        $entitlement=$arreglo['entitlement'];
                        $meta_calculada=$arreglo['meta_calculada'];
                        $meta_retadora=$arreglo['meta_retadora'];
                        $anio_kpi=$arreglo['anio_kpi'];
                        $mes_cierre=$arreglo['mes_cierre'];
                        $semana_kpi=$arreglo['semana_kpi'];
                        $dato_semanal=$arreglo['dato_semanal'];
                        $resultado = insertar($id_equipo,$nombre,$unidad,$linea_base,$entitlement,$meta_calculada,$meta_retadora,$anio_kpi,$semana_kpi,$dato_semanal,$mes_cierre);
                    }else{
                        $resultado = "No llegaron las variables para guardar";
                    }
                break;
            case 'PUT':
                if($arreglo['accion']=='Bases'){
                        if(isset($arreglo['id_equipo']) && isset($arreglo['actualizar']) && isset($arreglo['nuevo_valor'])){
                            $resultado = actualizarBaseKpi($arreglo['id_equipo'],$arreglo['actualizar'],$arreglo['nuevo_valor']);
                        }else{
                            $resultado = "No llegaron las variables para actualizar";
                        }
                }else if($arreglo['accion']=='Datos'){
                        if(isset($arreglo['id_equipo']) && isset($arreglo['id_registro'])&& isset($arreglo['mes_cierre_anterior']) && isset($arreglo['mes_cierre']) && isset($arreglo['semana']) && isset($arreglo['dato_semanal']) && isset($arreglo['anio'])){
                            $id_equipo = $arreglo['id_equipo'];
                            $id_registro =  $arreglo['id_registro'];
                            $mes_cierre = $arreglo['mes_cierre'];
                            $mes_cierre_anterior = $arreglo['mes_cierre_anterior'];
                            $anio = $arreglo['anio'];
                            $semana =  $arreglo['semana'];
                            $dato =  $arreglo['dato_semanal'];
                            //$resultado = "Listo para actualizar llegaron todas";
                            $resultado = actualizarDatoKpi($id_equipo,$id_registro,$anio,$mes_cierre_anterior,$mes_cierre,$semana,$dato);
                        }else{
                            $resultado = "No llegaron toadas la variables de Datos";
                        }
                }else{
                           $resultado = "No se reconoce esa acción";
                }
                //$resultado = 
                break;
            case 'DELETE':
                    if(isset($_GET['id_dato'])){
                        $id_dato = $_GET['id_dato'];
                        $resultado = eliminarDatoKpi($id_dato);
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