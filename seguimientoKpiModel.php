<?php
include("conexionGhoner.php");

    function consultar($id_equipo){
       global $conexion;
       $resultado = [];
       $resultadoPilares =[];
       $idsPilares = '';
       $estado = false;
       $posiciones =0;
       /* $sql = "SELECT * FROM kpis_proyectos WHERE  id_equipo=? AND proyecto_cerrado !='Si'"; */
       $sql = "SELECT * FROM kpis_proyectos WHERE  id_equipo=? AND proyecto_cerrado !='Si'";
       $stmt=$conexion->prepare($sql);
       if(!$stmt){ return array(false,"Error en la preparacion".$conexion->error);}
       $stmt->bind_param("i",$id_equipo);
       if(!$stmt->execute()){ array(false,"Error en la consultar".$stmt->error);}
       $datos = $stmt->get_result();
       while($fila = $datos->fetch_assoc()){
        $resultado[] = $fila;
        $idsPilares = $fila['pilares'];
       }
       $stmt->close();
      
       $arrayPilares = json_decode($idsPilares, true);
        //echo "ESTO TIENE".printf($arrayPilares);
       if(is_array($arrayPilares)){
            $posiciones = count($arrayPilares);
       }
       
       for($i = 0; $i < $posiciones; $i++ ){
            $id = $arrayPilares[$i];
             // Consulta dentro del ciclo
            $consulta = "SELECT * FROM pilares WHERE id=?";
            $stmt = $conexion->prepare($consulta);
            if(!$stmt){ return array(false,"Error en la preparacion".$conexion->error);}
            $stmt->bind_param("i", $id); // "i" indica que es integer
            if(!$stmt->execute()){ array(false,"Error en la consultar".$stmt->error);}
            // Obtener resultados
            $resultados = $stmt->get_result();
            while ($fila = $resultados->fetch_assoc()) {
               $resultadoPilares[] = $fila;
            }

            $stmt->close(); // cerramos el statement antes de la siguiente iteración
       }
       $estado = true;
       return array($estado,$resultado,$resultadoPilares);
    }

    function insertar($id_equipo,$nombre,$tipo_grafica,$unidad,$linea_base,$entitlement,$meta_calculada,$meta_retadora,$anio_kpi,$semana_kpi,$dato_semanal,$mes_cierre){
        (int)$id_equipo;
        $linea_base = str_replace(',', '', $linea_base);//elimino las comas double no las acepta
        $entitlement = str_replace(',', '', $entitlement);//elimino las comas double no las acepta
        $meta_calculada = str_replace(',', '', $meta_calculada);//elimino las comas double no las acepta
        $meta_retadora = str_replace(',', '', $meta_retadora);//elimino las comas double no las acepta
        $dato_semanal = str_replace(',', '', $dato_semanal);//elimino las comas double no las acepta
        global $conexion;
        $insertar = "INSERT INTO kpis_proyectos (id_equipo,nombre_indicador,unidad, linea_base, entitlement, meta_calculada, meta_retadora, anio, semana, dato_semanal,mes_cierre,tipo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conexion->prepare($insertar);
        if(!$stmt){ return "Error en la preparacion:".$conexion->error;}
        $stmt->bind_param("issddddiidss", $id_equipo,$nombre,$unidad,$linea_base,$entitlement,$meta_calculada,$meta_retadora,$anio_kpi,$semana_kpi,$dato_semanal,$mes_cierre,$tipo_grafica);
        if(!$stmt->execute()){return "Error en la ejecucion:".$stmt->error;}
        if($mes_cierre!=''){//Si se cerro el mes hay que actualizar
            $vacio = '';
            $sql = "UPDATE kpis_proyectos SET mes_cierre=? WHERE id_equipo=? AND mes_cierre=? AND proyecto_cerrado !='Si'";
            $stmt = $conexion->prepare($sql);
            if(!$stmt){ return "Error en la preparacion:".$conexion->error;}
            $stmt->bind_param("sis",$mes_cierre,$id_equipo,$vacio);
            if(!$stmt->execute()){return "Error en la ejecucion:".$stmt->error;}
            }
        return true;
    }

    function actualizarBaseKpi($id_equipo,$actualizar_columna,$nuevo_dato){
        global $conexion;
        $nuevo_dato = str_replace(',', '', $nuevo_dato);//elimino las comas double no las acepta
        $actualizar = "UPDATE kpis_proyectos SET $actualizar_columna='$nuevo_dato' WHERE id_equipo = $id_equipo AND proyecto_cerrado !='Si'";//Solo actualizara donde ID EQUIPO que no este cerrado.
        if($conexion->query($actualizar)){
            return true;
        }else{
            return false;
        }
    }

    function actualizarDatoKpi($id_equipo,$id_registro,$anio,$mes_cierre_anterior,$mes_cierre,$semana,$dato){
        global $conexion;
        $respuesta = "";
        $dato = str_replace(',', '', $dato);//elimino las comas double no las acepta
        $actualizar = "UPDATE kpis_proyectos SET anio='$anio', semana='$semana', dato_semanal='$dato' WHERE id='$id_registro' AND proyecto_cerrado !='Si'";
        if($conexion->query($actualizar)){
            $respuesta = true;
        }else{
            $respuesta = false;
        }

        if($mes_cierre_anterior!=$mes_cierre){
            $actualizar_mes = "UPDATE kpis_proyectos SET mes_cierre='$mes_cierre' WHERE proyecto_cerrado ='' AND id_equipo = '$id_equipo' AND mes_cierre = '$mes_cierre_anterior' AND proyecto_cerrado !='Si'";  
            if($conexion->query($actualizar_mes)){
                $respuesta = true;
            }else{
                $respuesta = $conexion->error;
            }
        }

        return array($respuesta);
    }

    function eliminarDatoKpi($id_dato){
        global $conexion;
        $eliminar = "DELETE FROM kpis_proyectos WHERE id = ?";
        $stmt = $conexion->prepare($eliminar);
        if(!$stmt){ return "Error en la preparacion:".$conexion->error;}
        $stmt->bind_param("i",$id_dato);
        if(!$stmt->execute()){return "Error en la ejecucion:".$stmt->error;}
        return true;
    }
?>