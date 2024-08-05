<?php
include("conexionGhoner.php");

    function consultarForos(){
        global $conexion;
        $resultado = [];
        $estado = false;
        $consulta = "SELECT * FROM foros";
        $query = $conexion->query($consulta);
        if($query){
            $estado=true;
        }
        if ($query->num_rows > 0) {
            while ($fila = $query->fetch_assoc()) {
                 $resultado [] = $fila;
            }
        }

        return array($estado,$resultado);
    }

    function consultarDetallesForo($id){
        global $conexion;
        $EADsForo = array();
        $evaluadoresForo = array();
        $calificacionEvaludorForo = array();
        $estado = false;
        $estado2 = false;
        $estado3 = false;

       // Consulta preparada para evitar inyección SQL
       $consulta = "SELECT ead_foro_id, proyecto, nombre_ead, id_evaluador, planta, area, suma 
       FROM (
          SELECT ef.id AS ead_foro_id, ef.proyecto, e.nombre_ead, c.id_evaluador, e.planta, e.area, SUM(c.calificacion) AS suma 
          FROM equipos_ead e
          JOIN ead_foro ef ON e.id = ef.id_equipos_ead
          JOIN calificacion c ON c.id_ead_foro = ef.id
          WHERE ef.id_foro = ?
          GROUP BY ef.id_equipos_ead 
       ) AS subconsulta ORDER BY suma DESC";

        // Preparar la consulta
        if ($stmt = $conexion->prepare($consulta)) {
        // Vincular parámetro
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
        // Obtener resultados
        $result = $stmt->get_result();
        while ($fila = $result->fetch_assoc()) {
            $EADsForo[] = $fila;
        }
        $estado = true;
            //recuperando los datos de los evaluadores del foro id
            $consulta2 = "SELECT evaluadores.id, evaluadores.nombre FROM ead_foro 
            JOIN calificacion ON ead_foro.id = calificacion.id_ead_foro
            JOIN evaluadores ON calificacion.id_evaluador = evaluadores.id
            WHERE ead_foro.id_foro = ? GROUP BY calificacion.id_evaluador";
            $stmt = $conexion->prepare($consulta2);
            $stmt->bind_param("i",$id);
                if($stmt->execute()){
                    $datos=$stmt->get_result();
                    while ($fila = $datos->fetch_assoc()) {
                        $evaluadoresForo[] = $fila;
                    }
                    $estado2 = true;
                        //recuperando calificacion por evaluador
                        $consulta2 = "SELECT ead_foro.id AS id_ead_foro, evaluadores.id AS id_evaluador, 
                        evaluadores.nombre, calificacion.calificacion
                        FROM ead_foro 
                        JOIN calificacion ON ead_foro.id = calificacion.id_ead_foro
                        JOIN evaluadores ON calificacion.id_evaluador = evaluadores.id
                        WHERE ead_foro.id_foro = ?";
                        $stmt = $conexion->prepare($consulta2);
                        $stmt->bind_param("i",$id);
                            if($stmt->execute()){
                                $datos=$stmt->get_result();
                                while ($fila = $datos->fetch_assoc()) {
                                    $id_ead_foro = $fila['id_ead_foro'];
                                    $id_evaluador = $fila['id_evaluador'];
                                    $calificacion = $fila['calificacion'];
                            
                                    if (!isset($calificacionEvaludorForo[$id_ead_foro])) {
                                        $calificacionEvaludorForo[$id_ead_foro]['suma'] = 0;
                                    }
                                    if (!isset($calificacionEvaludorForo[$id_ead_foro][$id_evaluador])) {
                                        $calificacionEvaludorForo[$id_ead_foro][$id_evaluador] = array(
                                            'nombre' => $fila['nombre'],
                                            'calificacion' => $calificacion,
                                        );
                                    }
                            
                                    // Sumamos la calificación al total del foro y al evaluador
                                    $calificacionEvaludorForo[$id_ead_foro]['suma'] += $calificacion;
                                }
                                $estado3 = true;
                            }else{
                                $estado3 = false;
                            }
                            
                }else{
                    $estado2 = false;
                }
        } else {
        // Manejar error de ejecución de la consulta
        $estado = $conexion->error;
        }
        // Cerrar declaración
        $stmt->close();
        } else {
        // Manejar error de preparación de la consulta
        $estado = $conexion->error;
        // Log o manejo del error
        }

        return array($estado,$EADsForo,$estado2,$evaluadoresForo,$estado3,$calificacionEvaludorForo);
    }

    function consultarEADxPlantaxArea($planta,$area){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM equipos_ead WHERE planta LIKE '%$planta%' AND area LIKE '%$area%' ORDER BY id DESC";
            $query = $conexion->query($consulta);
            if($query){
                while ($datos=mysqli_fetch_array($query)){
                    $resultado [] = $datos;
                }
                    $estado  = true;
            }else{
                    $estado  = false;
            }
            return array ($resultado,$estado);
    }

    function consultarEADSxPlanta($planta){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM equipos_ead WHERE planta LIKE '%$planta%' ORDER BY id DESC";
            $query = $conexion->query($consulta);
            if($query){
                while ($datos=mysqli_fetch_array($query)){
                    $resultado [] = $datos;
                }
                    $estado  = true;
            }else{
                    $estado  = false;
            }
            return array ($resultado,$estado);
    }

    function guardarForo($nombre_foro,$planta,$area,$fecha,$ids_ead,$ids_evaluadores){
        global $conexion;
        $estado = [];
        $query = "INSERT INTO foros (nombre_foro,planta,area,foro,fecha,estatus) VALUES (?,?,?,?,?,?)";
        $stmt = $conexion->prepare($query);
        $foro = "Áreas";
        $estatus = "Abierto";
        $stmt->bind_param("ssssss", $nombre_foro,$planta,$area,$foro,$fecha,$estatus);
        if($stmt->execute()){//guardo el foro
            $estado[0] = true;
            $ultimo_id = $conexion->insert_id;// tomo el id nuevo creado del foro.
            //COMBINANDO LOS FOROS Y EQUIPOS
            foreach ($ids_ead as $id_ead) {
                $query2="INSERT INTO ead_foro (id_foro, id_equipos_ead) VALUES (?,?)";
                $stmt = $conexion->prepare($query2);
                $stmt -> bind_param('ii',$ultimo_id,$id_ead); //insertando el id del foro en cada equipo
                if($stmt->execute()){
                    $estado[1] = true;
                    $ultimo_id_ead_foros=$conexion->insert_id; //tomo el id de ead_foro

                        //INSERTANDO EVALUADORES EN CALIFICACIONES
                        foreach ($ids_evaluadores as $id_eval) {
                            $query3="INSERT  INTO calificacion (id_ead_foro, id_evaluador) VALUES (?,?)";
                            $stmt = $conexion->prepare($query3);
                            $stmt -> bind_param('ii',$ultimo_id_ead_foros,$id_eval); //insertando el id del foro en cada equipo
                            if($stmt ->execute()){
                                $estado[2] = true;
                                $conexion->insert_id; //tomo el id de ead_foro

                                        $seleccionar = "SELECT * FROM preguntas";//selecciono las preguntas para replicar
                                        $resultados = mysqli_query($conexion,$seleccionar);
                                        if($resultados){
                                            $estado[3] = true;
                                            while($fila = mysqli_fetch_array($resultados)){
                                                $etapa = $fila['etapa'];
                                                $peso = $fila['peso'];
                                                $pregunta = $fila['pregunta'];
                                                $insertando = "INSERT INTO preguntas_evaluador (id_evaluador,id_ead_foro,etapa,peso,pregunta) VALUES (?,?,?,?,?)";
                                                $stmt = $conexion->prepare($insertando);
                                                $stmt->bind_param("iisss", $id_eval,$ultimo_id_ead_foros, $etapa, $peso, $pregunta);
                                                if($stmt->execute()){
                                                    $estado[4] = true;
                                                }
                                            }
                                        }

                            }else{
                                $estado[2] = $conexion->error;
                            }
                        }
                }else{
                    $estado[1] = $conexion->error;
                }
            }
        }else{
            $estado[0] =$conexion->error;
        }
        $stmt->close();
        return array($estado,$ids_ead,$ids_evaluadores);
    }

    function actualizandoNombreProyecto($id,$nombre){
        global $conexion;
        $estado = false;
        $update = "UPDATE ead_foro SET proyecto=? WHERE id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("si", $nombre, $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }



    function eliminar($id){
        global $conexion;
        $estado = false;
        $delete = "DELETE FROM misiones WHERE id=?";
        $stmt = $conexion->prepare($delete);
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }
?>