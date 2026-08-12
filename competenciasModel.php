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
       $consulta = "SELECT ead_foro_id, id_foro, id, id_foro, proyecto, nombre_ead, id_evaluador, planta, area, orden, suma
       FROM (
          SELECT ef.id AS  ead_foro_id, ef.id_foro, e.id, ef.proyecto, e.nombre_ead, c.id_evaluador, e.planta, e.area, ef.orden, SUM(c.calificacion) AS suma 
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
            $numeroOrden = 1;
            foreach ($ids_ead as $id_ead) {
                $query2="INSERT INTO ead_foro (id_foro, id_equipos_ead, orden) VALUES (?,?,?)";
                $stmt = $conexion->prepare($query2);
                $stmt -> bind_param('iii',$ultimo_id,$id_ead, $numeroOrden); //insertando el id del foro en cada equipo
                if($stmt->execute()){
                    $numeroOrden++;
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

    function editarOrdenEquiposForo($ead_foro_id, $ordenActual, $nuevoOrden, $ead_foro_id_dos){
        global $conexion;

        if($ead_foro_id == $ead_foro_id_dos){
            return "Mismo registro..";
        }

        $updateOrder = $conexion->prepare("UPDATE `ead_foro` SET `orden` = ? WHERE id = ?");
        $updateOrder->bind_param("ii", $nuevoOrden, $ead_foro_id);
        $updateOrder->execute();

        $updateAnteriorOrden = $conexion->prepare("UPDATE `ead_foro` SET `orden` = ? WHERE `id` = ?");
        $updateAnteriorOrden->bind_param("ii", $ordenActual, $ead_foro_id_dos);
        $updateAnteriorOrden->execute();
        
        $updateAnteriorOrden->close();
        $updateOrder->close();
    }

    function eliminarEquipoEADForo($ead_foro_id, $id_foro, $ordenActual) {

        global $conexion;
        $estado = ['false', 'false'];

        $eliminarEquipoForo = $conexion->prepare("DELETE FROM  `ead_foro` WHERE `id` = ?");
        $eliminarEquipoForo->bind_param("i", $ead_foro_id);
        $eliminarEquipoF = $eliminarEquipoForo->execute();

        if($eliminarEquipoF){
         $estado[0] = true;
        }

        $updateOrden = $conexion->prepare("UPDATE `ead_foro` SET `orden` = orden-1 WHERE `id_foro` = ? AND orden > ?");
        $updateOrden->bind_param("ii", $id_foro, $ordenActual);
        $updateOrdenEquipo =  $updateOrden->execute();

        if($updateOrdenEquipo){
         $estado[1] = true;
        }

        $eliminarEquipoForo->close();
        $updateOrden->close();

        return $eliminarEquipoF && $updateOrdenEquipo;

    }
    function consultarDetallesEquiposEADSForos($id_foro)
    {
        global $conexion;
        $estado = false;
        $equiposEADS = [];
        $equiposExistentes = [];
        $consultarForoEAD = $conexion->prepare("
                SELECT fr.id, fr.nombre_foro, fr.planta, fr.area, fr.foro, eadf.*  
                    FROM foros fr
                        LEFT JOIN ead_foro eadf
                        ON eadf.id_foro = fr.id
                    WHERE fr.id = ?;
                ");
        $consultarForoEAD->bind_param("i", $id_foro);
        $consultarForoEAD->execute();
        $result = $consultarForoEAD->get_result();

        if ($result->num_rows > 0) {
            while ($resultado = $result->fetch_assoc()) {
                $area = $resultado['area'];
                $planta = $resultado['planta'];
                $equiposExistentes[] = $resultado['id_equipos_ead'];
            }

            $consultarForoEAD->close();
            $idsEquiposExistentes = implode(',', array_map('intval', $equiposExistentes));

            if ($area == 'Multiárea' && $planta == '') {
                $consultarEquiposEADForoGlobal = $conexion->prepare("SELECT * FROM `equipos_ead` WHERE `id` NOT IN($idsEquiposExistentes)");
                $consultarEquiposEADForoGlobal->execute();
                $resultadoEquipoForoGlobal = $consultarEquiposEADForoGlobal->get_result();

                if ($resultadoEquipoForoGlobal->num_rows > 0) {
                    while ($resultadoEads = $resultadoEquipoForoGlobal->fetch_assoc()) {
                        $equiposEADS[] = $resultadoEads;
                    }
                    $estado = true;
                }
                $resultadoEquipoForoGlobal->close();
            } else {

                $consultarEquiposEADForo = $conexion->prepare("SELECT * FROM `equipos_ead` WHERE planta = ? AND area = ? AND `id` NOT IN ($idsEquiposExistentes)");
                $consultarEquiposEADForo->bind_param("ss", $planta, $area);
                $consultarEquiposEADForo->execute();
                $resultadoEquipos = $consultarEquiposEADForo->get_result();

                if ($resultadoEquipos->num_rows > 0) {
                    while ($resultadoEADs = $resultadoEquipos->fetch_assoc()) {
                        $equiposEADS[] = $resultadoEADs;
                    }
                    $estado = true;
                }
                $resultadoEquipos->close();
            }
        } else {
            $resultado = null;
            $equiposEADS = [];
            $estado = false;
        }

        return array($equiposEADS, $estado);
    }

    function consultarDetallesEquipo($id_ead_equipo) {
        global $conexion;
        $estado = false;
        $consultaEquipoEAD = null;

        $consulta = $conexion->prepare("SELECT * FROM `equipos_ead` WHERE id = ?");
        $consulta->bind_param("i", $id_ead_equipo);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if($resultado->num_rows > 0) {
            $estado = true;
            $consultaEquipoEAD = $resultado->fetch_assoc();

        } else {
            $estado = false;
        }
        $consulta->close();
    
        return array($estado, $consultaEquipoEAD);
    }
    function agregarEquipoForoExistente($id_ead_equipo, $id_foro)
    {
        global $conexion;
        $estado = false;
        $idEvaluadores = [];


        /*========== Validar si ya existe en la bd. ==========*/
        $consulta = $conexion->prepare("SELECT * FROM `ead_foro` WHERE id_foro = ? AND id_equipos_ead = ?");
        $consulta->bind_param("ii", $id_foro, $id_ead_equipo);

        if (!$consulta->execute()) {
            return $estado;
        }
        $equipoExiste = $consulta->get_result();
        if ($equipoExiste->num_rows > 0) {
            return $estado;
        }


        $idDeEADForo = $conexion->prepare("SELECT id FROM `ead_foro` WHERE id_foro = ? ORDER BY id ASC LIMIT 1");
        $idDeEADForo->bind_param("i", $id_foro);
        $idDeEADForo->execute();
        $idDeEADResultado = $idDeEADForo->get_result();

        if ($idDeEADResultado->num_rows > 0) {
            $idEquipoA = $idDeEADResultado->fetch_assoc();
            $idAnteriorEquipo = $idEquipoA['id'];

            $evaluadoresCalificacion = $conexion->prepare("SELECT id_evaluador FROM `calificacion` WHERE id_ead_foro = ?");
            $evaluadoresCalificacion->bind_param("i", $idAnteriorEquipo);
            $evaluadoresCalificacion->execute();
            $evaluadores = $evaluadoresCalificacion->get_result();

            if ($evaluadores->num_rows > 0) {
                while ($evaluadoresResultado = $evaluadores->fetch_assoc()) {
                    $idEvaluadores[] = $evaluadoresResultado['id_evaluador'];
                }
            } else {
                return $estado;
            }
        } else {
            return $estado;
        }


        $agregarEquipoEnForoExiste = $conexion->prepare("INSERT INTO `ead_foro` (id_foro, id_equipos_ead, orden) SELECT ?, ?, COALESCE(MAX(orden), 0) + 1 FROM `ead_foro` WHERE id_foro = ?");
        $agregarEquipoEnForoExiste->bind_param("iii", $id_foro, $id_ead_equipo, $id_foro);

        if ($agregarEquipoEnForoExiste->execute()) {
            $id_ead_NuevoEquipo = $conexion->insert_id;
        } else {
            return $estado;
        }

        $preguntas = $conexion->prepare("SELECT * FROM `preguntas`");
        $preguntas->execute();
        $resultadoP = $preguntas->get_result();
        $preguntasTotales = [];

        while ($datoP = $resultadoP->fetch_assoc()) {
            $preguntasTotales[] = $datoP;
        }

        $InsertEvaluadorEquipoN = $conexion->prepare("INSERT INTO `calificacion` (id_ead_foro, id_evaluador) VALUES (?,?)");

        $preguntasEnPreguntasEva = $conexion->prepare("INSERT INTO `preguntas_evaluador` (id_evaluador, id_ead_foro, etapa, peso, pregunta) VALUES (?,?,?,?,?)");

        foreach ($idEvaluadores as $idEvaluador) {
            $InsertEvaluadorEquipoN->bind_param("ii", $id_ead_NuevoEquipo, $idEvaluador);
            if ($InsertEvaluadorEquipoN->execute()) {

                foreach ($preguntasTotales as $pregunta) {
                    $preguntasEnPreguntasEva->bind_param(
                        "iisis",
                        $idEvaluador,
                        $id_ead_NuevoEquipo,
                        $pregunta['etapa'],
                        $pregunta['peso'],
                        $pregunta['pregunta']
                    );
                    $preguntasEnPreguntasEva->execute();
                }
            }
        }
        $estado = true;
        return $estado;
    }
    function cambiarEquipoEnForoExistente( $id_anteriorEquipo,  $id_nuevoEquipo) {
        global $conexion;
        $estado = false;

        $consulta = $conexion->prepare("UPDATE `ead_foro` SET id_equipos_ead = ? WHERE id_equipos_ead = ? ");
        $consulta->bind_param("ii", $id_nuevoEquipo, $id_anteriorEquipo);
        if($consulta->execute()){
            $estado = true;
        }
        $consulta->close();

        return $estado;
    }


    function actualizarEvaluadoresEnForo($deseleccionados, $agregados, $id_foro)
    {
        global $conexion;
        $estado = ['false', 'false', 'false'];
        $idEvaluadores = [];
        $idEquiposEAD = [];
        $idEquipoForos = [];

        //CONSULTAS GENERALES
        $consulta = $conexion->prepare("SELECT  c.id_evaluador, foroead.id_equipos_ead, foroead.id AS idDeEquipoEAD
                    FROM `calificacion` as c
                    INNER JOIN
                    ead_foro as foroead 
                    ON foroead.id = c.id_ead_foro
                    WHERE foroead.id_foro = ?");
        $consulta->bind_param("i", $id_foro);
        $consulta->execute();
        $resultadoc1 = $consulta->get_result();

        if ($resultadoc1->num_rows > 0) {

            while ($resultados = $resultadoc1->fetch_assoc()) {
                $idE = $resultados['id_evaluador'];
                $idEquipo = $resultados['id_equipos_ead'];
                $idEadForo = $resultados['idDeEquipoEAD'];
                //GUARDA EVALUADORES
                if (!in_array($idE, $idEvaluadores)) {
                    $idEvaluadores[] = $idE;
                }
                //GUARDA ID'S DE LOS EQUIPOS
                if (!in_array($idEquipo, $idEquiposEAD)) {
                    $idEquiposEAD[] = $idEquipo;
                }
                //GUARDAR LOS ID'S DE EAD_FOROS
                if (!in_array($idEadForo, $idEquipoForos)) {
                    $idEquipoForos[] = $idEadForo;
                }
            }
        } else {
            $estado[0];   
        }
        $consulta->close();

        //Extraer preguntas para insertar nuevamente.
        $preguntas = $conexion->prepare("SELECT * FROM `preguntas`");
        $preguntas->execute();
        $resultadop = $preguntas->get_result();
        $preguntasTotales = [];

        while ($datop = $resultadop->fetch_assoc()) {
            $preguntasTotales[] = $datop;
        }

        //Preparar para las consultas
        $idDeseleccionadoPreparadoi = implode(',', array_fill(0, count($deseleccionados), '?'));
        $idEadForoPreparadoi = implode(',', array_fill(0, count($idEquipoForos), '?'));

        //PREPARAR ELIMINAR
        if (!empty($idEquipoForos) && !empty($deseleccionados)) {

            $DeleteEquipo = $conexion->prepare("DELETE FROM `calificacion`
                    WHERE id_evaluador IN($idDeseleccionadoPreparadoi) 
                    AND id_ead_foro IN($idEadForoPreparadoi)");

            $DeletepreguntasEvaluador = $conexion->prepare("DELETE FROM `preguntas_evaluador` 
                    WHERE id_evaluador IN($idDeseleccionadoPreparadoi) 
                    AND id_ead_foro IN($idEadForoPreparadoi)");

            $contenido = array_merge($deseleccionados, $idEquipoForos);

            $tipo = str_repeat('i', count($contenido));
            $DeleteEquipo->bind_param($tipo, ...$contenido);
            $DeletepreguntasEvaluador->bind_param($tipo, ...$contenido);

            if (!$DeleteEquipo->execute()) {
                $estado[0];
            }

            if (!$DeletepreguntasEvaluador->execute()) {
                $estado[0];
            }
            $estado[1] = true;
            $DeleteEquipo->close();
            $DeletepreguntasEvaluador->close();
        }

        if (!empty($idEquipoForos) && !empty($agregados)) {

            $AddEquipoCalificacion = $conexion->prepare("INSERT INTO `calificacion` (id_ead_foro, id_evaluador) 
                VALUES (?,?)");

            $addEquipoPreguntasEv = $conexion->prepare("INSERT INTO `preguntas_evaluador` (id_evaluador, id_ead_foro, etapa, peso, pregunta) 
                VALUES(?,?,?,?,?)");

            foreach ($agregados as $idNuevosEva) {
                foreach ($idEquipoForos as $idEAD) {
                    $AddEquipoCalificacion->bind_param("ii", $idEAD, $idNuevosEva);
                    if ($AddEquipoCalificacion->execute()) {
                        foreach ($preguntasTotales as $pregunta) {
                            $addEquipoPreguntasEv->bind_param(
                                "iisis",
                                $idNuevosEva,
                                $idEAD,
                                $pregunta['etapa'],
                                $pregunta['peso'],
                                $pregunta['pregunta']
                            );
                            $addEquipoPreguntasEv->execute();
                        }
                    }
                }
            }

            $estado[2] = true;
            $AddEquipoCalificacion->close();
            $addEquipoPreguntasEv->close();
            
        }
        return $estado;
    }
    function consultarEvaluadoresExistentes($idForo) {
        global $conexion;
        $estado = false;
        $evaluador = [];

        //CONSULTAS GENERALES
        $consulta = $conexion->prepare("SELECT  c.*, foroead.id_equipos_ead
                    FROM `calificacion` as c
                    INNER JOIN
                    ead_foro as foroead 
                    ON foroead.id = c.id_ead_foro
                    WHERE foroead.id_foro = ?;");
        $consulta->bind_param("i", $idForo);
        $consulta->execute();
        $resultadoc1 = $consulta->get_result();

        if ($resultadoc1->num_rows > 0) {

            while ($resultados = $resultadoc1->fetch_assoc()) {
                
                if(!isset($evaluador[$resultados['id_ead_foro']][$resultados['id_evaluador']])){
                    $evaluador[$resultados['id_ead_foro']][$resultados['id_evaluador']] = array(
                        'id_evaluador' => $resultados['id_evaluador'],
                        'id_equipos_ead' => $resultados['id_equipos_ead'],
                        'calificacion' => $resultados['calificacion'],
                        'id_ead_foros' => $resultados['id_ead_foro']
                    );
                }
            }
            $estado = true;
        } else {
            $estado = false;   
        }
        $consulta->close();
        return array($estado, $evaluador);

    }
    function consultaEvaluadoresGenerales($idForo) {
        global $conexion;
        $estado = false;
        $calificacionEva = [];

        $consulta = $conexion->prepare("SELECT DISTINCT
                        foroead.id,
                        c.id_evaluador,
                        eva.nombre,
                        foroead.id_equipos_ead
                    FROM calificacion AS c
                    INNER JOIN ead_foro AS foroead
                        ON foroead.id = c.id_ead_foro
                    INNER JOIN evaluadores AS eva
                        ON eva.id = c.id_evaluador
                    WHERE foroead.id_foro = ?
                    AND c.calificacion > 0;
                    ");
        $consulta->bind_param("i", $idForo);
        $consulta->execute();
        $consultares = $consulta->get_result();

        if($consultares->num_rows > 0) {    

            while($resultado = $consultares->fetch_assoc()) {
                $existeid = false;
                foreach ($calificacionEva as $evaluadorid) {
                    if($evaluadorid['id_evaluador'] == $resultado['id_evaluador'])  {
                        $existeid = true;
                        break;
                    }
                }
                if(!$existeid) {
                    $calificacionEva[] = $resultado;
                }
            }
            $estado = true;
        } else{
            $estado = false;
        }
        $consulta->close();

        return array($estado, $calificacionEva);

    }

    function cambiarEvaluadoresConCalificacion($id_foro, $ids_eva_anterior, $id_eva_nuevo)
    {
        global $conexion;
        $estado = false;
        $id_equipos_eadforo = [];
        $ids_calificacion = [];
        $idCalEvaAnterior = [];
        $idCalEvaNuevo = [];
        $idPreguntasEvaAnt = [];
        $idpreguntasEvaNue = [];


        // CONSULTA PARA SABER SI EXISTE AL MENOS UN SOLO REGISTRO DE CALIFICACIÓN DE EVALUADOR
        $consulta = $conexion->prepare("SELECT c.id, c.id_evaluador, foroead.id_equipos_ead, foroead.id AS idDeEquipoEAD
                    FROM `calificacion` as c
                        INNER JOIN
                        ead_foro as foroead 
                        ON foroead.id = c.id_ead_foro
                    WHERE foroead.id_foro = ?
                    AND c.id_evaluador = ? ");
        $consulta->bind_param("ii", $id_foro, $ids_eva_anterior);
        $consulta->execute();
        $resultado1 = $consulta->get_result();

        if ($resultado1->num_rows > 0) {

            while ($dato = $resultado1->fetch_assoc()) {
                // $ids_calificacion[] = $dato['id'];

                if (!in_array($dato['idDeEquipoEAD'], $id_equipos_eadforo)) {
                    $id_equipos_eadforo[] = $dato['idDeEquipoEAD'];
                }
            }
            $placeholderidEquiposEAD = implode(',', array_fill(0, count($id_equipos_eadforo), '?'));


            //CONSULTAR SI EXISTE EL EVALUADOR QUE POR EL QUE SE QUIERE CAMBIAR.
            // die();
            $consulta = $conexion->prepare("SELECT * FROM `calificacion` WHERE `id_evaluador` = ?");
            $consulta->bind_param("i", $id_eva_nuevo);
            $consulta->execute();
            $consulta1 = $consulta->get_result();

            if ($consulta1->num_rows > 0) {

                if (!empty($ids_eva_anterior) && !empty($id_eva_nuevo)) {

                    /*========== CALIFICACION EVALUADOR ORIGINALES ==========*/
                    $evaluador = $conexion->prepare("SELECT `id` FROM `calificacion` WHERE id_ead_foro IN($placeholderidEquiposEAD) AND id_evaluador = ?");
                    if (!$evaluador) {
                        die("Error en prepare(): " . $conexion->error);
                    }

                    //Evaluador anterior
                    $contenido = array_merge($id_equipos_eadforo, [$ids_eva_anterior]);
                    $tipos = str_repeat('i', count($contenido));

                    if (!$evaluador->bind_param($tipos, ...$contenido)) {
                        die("Error en bind_param(): " . $evaluador->error);
                    }
                    if (!$evaluador->execute()) {
                        die("Error en execute() evaluador anterior: " . $evaluador->error);
                    }
                    $resultado = $evaluador->get_result();

                    if ($resultado === false) {
                        die("Error en get_result(): " . $evaluador->error);
                    }

                    while ($dato = $resultado->fetch_assoc()) {
                        $idCalEvaAnterior[] = $dato['id'];
                    }

                    //Evaluador nuevo
                    $contenido = array_merge($id_equipos_eadforo, [$id_eva_nuevo]);
                    $tipos = str_repeat('i', count($contenido));

                    if (!$evaluador->bind_param($tipos, ...$contenido)) {
                        die("Error en bind_param(): " . $evaluador->error);
                    }

                    if (!$evaluador->execute()) {
                        die("Error en execute() evaluador nuevo: " . $evaluador->error);
                    }

                    $resultado = $evaluador->get_result();

                    if ($resultado === false) {
                        die("Error en get_result(): " . $evaluador->error);
                    }

                    while ($dato = $resultado->fetch_assoc()) {
                        $idCalEvaNuevo[] = $dato['id'];
                    }

                    $evaluador->close();

                    /*========== PREGUNTAS EVALUADOR ORIGINALES ==========*/
                    $preguntas_evaluador = $conexion->prepare("SELECT id 
                            FROM `preguntas_evaluador` 
                            WHERE id_ead_foro IN($placeholderidEquiposEAD) 
                            AND id_evaluador = ? ;");
                    if (!$preguntas_evaluador) {
                        die("Error en prepare(): " . $conexion->error);
                    }
                    //Evaluador anterior
                    $contenido = array_merge($id_equipos_eadforo, [$ids_eva_anterior]);
                    $tipos = str_repeat('i', count($contenido));

                    if (!$preguntas_evaluador->bind_param($tipos, ...$contenido)) {
                        die("Error en bind_param(): " . $preguntas_evaluador->error);
                    }

                    if (!$preguntas_evaluador->execute()) {
                        die("Error en execute() preguntas_evaluador anterior: " . $preguntas_evaluador->error);
                    }

                    $resultado = $preguntas_evaluador->get_result();

                    if ($resultado === false) {
                        die("Error en get_result(): " . $preguntas_evaluador->error);
                    }

                    while ($dato = $resultado->fetch_assoc()) {
                        $idPreguntasEvaAnt[] = $dato['id'];
                    }
                    //Evaluador nuevo
                    $contenido = array_merge($id_equipos_eadforo, [$id_eva_nuevo]);
                    $tipos = str_repeat('i', count($contenido));

                    if (!$preguntas_evaluador->bind_param($tipos, ...$contenido)) {
                        die("Error en bind_param(): " . $preguntas_evaluador->error);
                    }

                    if (!$preguntas_evaluador->execute()) {
                        die("Error en execute() preguntas_evaluador nuevo: " . $preguntas_evaluador->error);
                    }

                    $resultado = $preguntas_evaluador->get_result();

                    if ($resultado === false) {
                        die("Error en get_result(): " . $preguntas_evaluador->error);
                    }

                    while ($dato = $resultado->fetch_assoc()) {
                        $idpreguntasEvaNue[] = $dato['id'];
                    }

                    $preguntas_evaluador->close();

                    $ids = array_merge($idCalEvaAnterior, $idCalEvaNuevo);
                    $idsCalnuevoEva = implode(',', $idCalEvaNuevo);
                    $idsCalAntEva = implode(',', $idCalEvaAnterior);
                    $idsCalificacionP = implode(',', $ids);

                    $idsP = array_merge($idPreguntasEvaAnt, $idpreguntasEvaNue);
                    $idsPreguntasNue = implode(',', $idpreguntasEvaNue);        
                    $idsPreguntasAnt = implode(',',$idPreguntasEvaAnt);
                    $idsPreguntasP = implode(',', $idsP);                    

                    /*========== Realizar update de tabla calificacion ==========*/
                    $Updatecalificacion = $conexion->prepare("UPDATE `calificacion` 
                                                    SET `id_evaluador` = CASE 
                                                        WHEN `id` IN($idsCalnuevoEva) THEN ?
                                                        WHEN `id` IN($idsCalAntEva) THEN ?
                                                    END
                                                    WHERE `id` IN($idsCalificacionP)");
                    if (!$Updatecalificacion) {
                        die("Error en prepare: " . $conexion->error);
                    }
                    $Updatecalificacion->bind_param(
                        "ii",
                        $ids_eva_anterior,
                        $id_eva_nuevo,
                    );
                    if (!$Updatecalificacion->execute()) {
                        die("Error en execute(): " . $Updatecalificacion->error);
                    }

                    /*========== Realizar update tabla preguntas_evaluador ==========*/
                    $UpdatePreguntasEva = $conexion->prepare("UPDATE `preguntas_evaluador`
                                                SET `id_evaluador` = CASE
                                                    WHEN `id` IN($idsPreguntasNue) THEN ?
                                                    WHEN `id` IN($idsPreguntasAnt) THEN ?
                                                END 
                                                WHERE `id` IN($idsPreguntasP)");
                    if (!$UpdatePreguntasEva) {
                        die("Error en prepare: " . $conexion->error);
                    }
                    $UpdatePreguntasEva->bind_param(
                        "ii",
                        $ids_eva_anterior,
                        $id_eva_nuevo,

                    );
                    if (!$UpdatePreguntasEva->execute()) {
                        die("Error en execute(): " . $UpdatePreguntasEva->error);
                    }
                    $Updatecalificacion->close();
                }
                $estado = true;

            } else {
                if (!empty($ids_eva_anterior) && !empty($id_eva_nuevo)) {

                    $calificacion = $conexion->prepare("UPDATE `calificacion` 
                                        SET `id_evaluador` = ? 
                                    WHERE `id_ead_foro` IN($placeholderidEquiposEAD)
                                    AND `id_evaluador` = ?");

                    $preguntasEvaluador = $conexion->prepare("UPDATE `preguntas_evaluador` 
                                        SET `id_evaluador` = ?
                                    WHERE `id_ead_foro` IN($placeholderidEquiposEAD) 
                                    AND `id_evaluador` = ?");

                    $contenido = array_merge(
                        [$id_eva_nuevo],
                        $id_equipos_eadforo,
                        [$ids_eva_anterior]
                    );

                    $tipo = str_repeat('i', count($contenido));
                    $calificacion->bind_param($tipo, ...$contenido);
                    $preguntasEvaluador->bind_param($tipo, ...$contenido);

                    if (!$calificacion->execute()) {
                        die("Error en prepare (): " . $conexion->error);
                    }
                    if (!$preguntasEvaluador->execute()) {
                        die("Error en prepare (): " . $conexion->error);
                    }
                    $estado = true;
                    $calificacion->close();
                    $preguntasEvaluador->close();
                }
            }
        } else {
            $estado = false;
        }
        $consulta->close();
        return $estado;
    }

    

 

?>
