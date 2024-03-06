<?php
include("conexionGhoner.php");

    function consultarCompetenciaXEvaluador($id_evaluador){
        global $conexion;
        $resultado = [];
        $estado = false;
        global $conexion; // assuming you have a global variable $conn that represents your database connection
        $query = "SELECT calificacion.id_ead_foro, equipos_ead.id, equipos_ead.nombre_ead, calificacion.calificacion FROM equipos_ead
        JOIN ead_foro ON equipos_ead.id = ead_foro.id_equipos_ead
        JOIN calificacion ON ead_foro.id = calificacion.id_ead_foro
        JOIN evaluadores ON calificacion.id_evaluador = evaluadores.id WHERE calificacion.id_evaluador='$id_evaluador' GROUP BY calificacion.id_ead_foro";
                
                $result = mysqli_query($conexion, $query);
                if($result){
                    $estado = true;
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result)){
                            $resultado [] = $row;
                        }
                       
                    }
                }else{
                    $estado = "La consulta de Evaluador no se realizo ".$conexion->error;
                }
        $conexion->close();
        return array($estado,$resultado);
    }

    function consultarDetallesForo($id){
    }

    function consultarEADxPlantaxArea($planta,$area){
    }


    function actualizarMision($id,$nuevoNombre){  
    }

    function eliminarMision($id){
    }
?>