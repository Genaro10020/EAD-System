<?php
include("conexionGhoner.php");

    function consultarPreguntasEvaluador($id_evaluador,$id_ead_foro){
        global $conexion;
        $etapas = [];
        $resultado = [];
        $sumas = [];
        $completo=[];
        $estado = false;
        $finalizo = "";
         $consulta = "SELECT * FROM preguntas_evaluador WHERE id_evaluador='$id_evaluador' AND id_ead_foro='$id_ead_foro'";
        $query = $conexion->query($consulta);
        if ($query) {
            $estado = true;
            if ($query->num_rows > 0) {
                while ($fila = $query->fetch_assoc()) {
                    $etapa = $fila['etapa'];
                    if (!isset($resultado[$etapa])) {
                        $resultado[$etapa] = []; // Crear nueva entrada para la etapa si no existe
                        $sumas[$etapa]['puntos_reales'] = 0;
                        $sumas[$etapa]['puntos_maximos'] = 0; // Agregar clave para la suma de preguntas
                        $sumas[$etapa]['ponderacion'] = intval($fila['peso']); // Agregar clave para la suma de preguntas
                    }
                    $resultado[$etapa][] = $fila;
                    $sumas[$etapa]['puntos_reales'] += $fila['valor'];
                    $sumas[$etapa]['puntos_maximos'] += 5;
                    
                    if($fila['valor']==Null){
                        $completo[] = "No";    
                    }else{
                        $completo[] = "Si"; 
                    }
                }
            }
        }
       
        if(in_array("No",$completo)){
            $finalizo = "No Finalizado";
        }else{
            $finalizo = "Finalizado";
        }


        return array($estado, $resultado,$sumas,$completo,$finalizo);
    }

    function actualizarValor($id_pregunta,$id_evaluador,$id_ead_foro,$valor){
        global $conexion;
        $estado = false;
        $update = "UPDATE preguntas_evaluador SET valor=? WHERE id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("ii", $valor, $id_pregunta);
        if($stmt->execute()){
            $estado = true;
        }else{
            $estado = $conexion->error;
        }
        $stmt->close();
        return array($estado);
    }

    function actualizarCalifacionEAD($id_calificacion,$calificacionEAD,$comentario){
        global $conexion;
        $estado = false;
        $update = "UPDATE calificacion SET calificacion=?,comentario=? WHERE id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("dsi", $calificacionEAD,$comentario, $id_calificacion);
        if($stmt->execute()){
            $estado = true;
        }else{
            $estado = $conexion->error;
        }
        $stmt->close();
        return array($estado);
    }


    function eliminarMision($id){
       
    }
?>