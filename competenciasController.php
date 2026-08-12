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
                            if(isset($_GET['accion']) && $_GET['accion']=='EADSxPlanta'){
                                    $planta = $_GET['planta'];
                                    $resultado = consultarEADSxPlanta($planta);
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
                            if(isset($_GET['accion']) && $_GET['accion']=='consultarEquiposEADAF'){
                                $id_foro = $_GET['id_foro'];
                                    $resultado = consultarDetallesEquiposEADSForos($id_foro);
                            }
                            if(isset($_GET['accion']) && $_GET['accion']=='consultarEquipo'){
                                $id_ead_equipo = $_GET['equipoIdForo'];
                                    $resultado = consultarDetallesEquipo($id_ead_equipo);
                            }
                            if(isset($_GET['accion']) && $_GET['accion'] == 'consultarEvaluadores') {
                                $idForo = $_GET['idForo'];

                                    $resultado = consultarEvaluadoresExistentes($idForo);
                            }
                            if(isset($_GET['accion']) && $_GET['accion'] == 'consultaEvaluadoresGenerales'){
                                $idForo = $_GET['idForo'];
                                 $resultado = consultaEvaluadoresGenerales($idForo);
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
                        if(isset($arreglo['accion']) && $arreglo['accion']=='editarOrden'){
                            $ead_foro_id = $arreglo['ead_foro_id'];
                            $ordenActual = $arreglo['ordenActual'];
                            $nuevoOrden = $arreglo['ordenDestino'];
                            $ead_foro_id_dos = $arreglo['ead_foro_id_dos'];

                            $resultado = editarOrdenEquiposForo($ead_foro_id, $ordenActual, $nuevoOrden, $ead_foro_id_dos);
                        }
                        if(isset($arreglo['accion']) && $arreglo['accion']=='eliminarEquipoForo'){

                            $ead_foro_id = $arreglo['ead_foro_id'];
                            $id_foro = $arreglo['id_foro'];
                            $ordenActual = $arreglo['ordenActual'];

                            $resultado = eliminarEquipoEADForo($ead_foro_id, $id_foro, $ordenActual );
                        }
                        if(isset($arreglo['accion']) && $arreglo['accion'] == 'AgregarEquipoForoExistente') {
                            $id_ead_equipo = $arreglo['id_ead'];
                            $id_foro = (int)$arreglo['id_foro'];

                                $resultado = agregarEquipoForoExistente($id_ead_equipo, $id_foro);
                        }
                        if(isset($arreglo['accion']) && $arreglo['accion'] == 'actualizarEvaluadoresForo') {
                            $deseleccionados = $arreglo['deseleccionados'];
                            $agregados = $arreglo['agregados'];
                            $id_foro = $arreglo['id_foro'];

                                $resultado = actualizarEvaluadoresEnForo($deseleccionados, $agregados, $id_foro);
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

                        if(isset($arreglo['accion']) && $arreglo['accion'] == 'CambiarEquipoEnForo') {
                            $id_anteriorEquipo = $arreglo['equipoAnterior'];
                            $id_nuevoEquipo = $arreglo['equipoNuevo'];

                            $resultado = cambiarEquipoEnForoExistente( $id_anteriorEquipo,  $id_nuevoEquipo);
                        }
                        if(isset($arreglo['accion']) && $arreglo['accion'] == 'cambiarEvaluador') {
                            $id_foro = $arreglo['id_foro'];
                            $ids_eva_anterior = $arreglo['id_eva_anterior'];
                            $id_eva_nuevo = $arreglo['id_eva_nuevo'];

                            $resultado = cambiarEvaluadoresConCalificacion($id_foro, $ids_eva_anterior, $id_eva_nuevo);
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