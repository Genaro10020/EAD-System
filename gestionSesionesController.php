<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("gestionSesionesModel.php");
        $resultado = "";  
        if(isset($arreglo['accion'])){
            $accion=$arreglo['accion'];
        } 
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                    $id_equipo = $_GET['id_equipo'];
                    if($_GET['accion'] == "ConsultarSeguimiento"){
                            $resultado = consultarSession($id_equipo);
                        }else if($_GET['accion'] == "ConsultarSeguimientoAsistencia"){
                            $anio=$_GET['anio'];
                            $mes=$_GET['mes'];
                            //consulto la gestion de sesiones para tomar el historia de asistencias ScoreCard
                            $resultado = consultarSessionAsistencia($id_equipo,$anio,$mes);
                        }else{
                            $resultado = "No existe esta acción";
                        }
                break;
            case 'POST':
          
                    if(isset($arreglo['accion']) && isset($arreglo['id_gestion_session']) && isset($arreglo['id_equipo']) && isset($arreglo['fecha']) && isset($arreglo['etapa']) && isset($arreglo['fases'])  && isset($arreglo['ids_integrantes']) && isset($arreglo['asistieron']) && isset($arreglo['porcentaje'])){
                        $accion=$arreglo['accion'];
                        $id_equipo=$arreglo['id_equipo'];
                        $fecha=$arreglo['fecha'];
                        $etapa=$arreglo['etapa'];
                        $fases=$arreglo['fases'];
                        $ids_integrantes=$arreglo['ids_integrantes'];
                        $asistieron=$arreglo['asistieron'];
                        $porcentaje=$arreglo['porcentaje'];
                        $id_gestion_session=$arreglo['id_gestion_session'];
                        $resultado = guardarActualizarSession($id_gestion_session,$accion,$id_equipo,$fecha,$etapa,$fases,$ids_integrantes,$asistieron,$porcentaje);
                    }else{
                        $resultado = "No existen todas la variables";
                    }
                
                break;
            case 'PUT':
                    if(isset($arreglo['id_equipo']) && isset($arreglo['accion']) && $arreglo['accion']=='cerrarProyecto' ){
                        $id_equipo =$arreglo['id_equipo'];
                        $resultado = cerrarProyecto($id_equipo);
                    }
                break;
            case 'DELETE':
                    if(isset($_GET['id_session'])){
                        $id_session=$_GET['id_session'];
                        $resultado= eliminarSession($id_session);
                    }else{
                        $resultado="No llego";
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