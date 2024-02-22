<?php
session_start();
if (isset($_SESSION['nombre'])) {
    $arreglo = json_decode(file_get_contents('php://input'), true);
    include("conexionGhoner.php");
    header('Content-Type: application/json');
    $accion = $arreglo['accion'];
    $validaciones = [];
    $equipos = array();
    $integrantesIDs = array(); 
    $integrantes= array(); 
    switch ($accion) {
        case 'consultar':
            $consulta = "SELECT * FROM equipos_ead ORDER BY id DESC";
    $result = $conexion->query($consulta);
    
    if ($result) {
        $validaciones[0] = true;
        include("conexionBDSugerencias.php");
        if($result->num_rows>0){
            while ($fila = $result->fetch_array()) {
                $equipos[] = $fila;
                $idEAD = $fila['id'];
                $integrantesIDs = json_decode($fila['integrantes'], true);
                if (!empty($integrantesIDs) && is_array($integrantesIDs)) {
                        foreach ($integrantesIDs as $idIntegrante) {
                            if (!isset($integrantes[$idEAD])) {
                                $integrantes[$idEAD] = []; // Inicializar el array si aún no existe
                            }
                            $consultaIntegrantes = "SELECT * FROM usuarios_colocaboradores_sugerencias WHERE id = '$idIntegrante'";
                            $resultIntegrantes = $conexion->query($consultaIntegrantes);
                            if($resultIntegrantes){
                                $validaciones[1] = true;
                                if ($resultIntegrantes->num_rows > 0) {
                                    while ($datos = $resultIntegrantes->fetch_assoc()) {
                                        $integrantes[$idEAD][] = $datos; // Agregar datos al array usando $idEAD como clave
                                    }
                                }
                            }else{
                                $validaciones[1] = false;
                            }
                        }
                    }
            }
        }
    } else {
        $validaciones[0] = false;
    }
    break;
        case 'insertar':
            $nombre = $arreglo['nombre'];
            $planta = $arreglo['planta'];
            $area = $arreglo['area'];
            $proceso = $arreglo['proceso'];
            $lider_equipo = $arreglo['lider'];
            $coordinador = $arreglo['coordinador'];
            $jefe_area = $arreglo['jefe_area'];
            $ing_proceso = $arreglo['ing_proceso'];
            $ing_calidad = $arreglo['ing_calidad'];
            $supervisor = $arreglo['supervisor'];
            $ids_integrantes = json_encode($arreglo['ids_integrantes'],JSON_UNESCAPED_UNICODE);
            $insertar = "INSERT INTO equipos_ead (nombre_ead,planta,area,proceso,lider_equipo,coordinador,jefe_area,ing_procesos,ing_calidad,supervisor,integrantes) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $conexion->prepare($insertar);
           
            if ($stmt === false) {
                $validaciones[0] = "Error en Bind" . $conexion->error;
            } else {
                $stmt->bind_param("sssssssssss", $nombre, $planta, $area, $proceso, $lider_equipo, $coordinador, $jefe_area, $ing_proceso, $ing_calidad, $supervisor,$ids_integrantes);
                if ($stmt->execute()) {
                    $validaciones[0] = true;
                    $id_integrante=json_decode($ids_integrantes,true);
                    $ultimo_id_insertado = $conexion->insert_id; // Obteniendo el último ID insertado
                    
                    include("conexionBDSugerencias.php");
                    foreach($id_integrante as $elemento ){
                        $update = "UPDATE usuarios_colocaboradores_sugerencias SET equipo_ead=? WHERE id=?";
                        $stmt=$conexion->prepare($update);
                        if($stmt!==false){
                            $validaciones[1] =true;
                            $stmt->bind_param("si",$ultimo_id_insertado,$elemento);
                            $stmt->execute();
                            $stmt->close();
                        }else{
                            $validaciones[1] ="Error al actualizar: ".$conexion->error;
                        }
                    }

                } else {
                    $validaciones[0] = "Error en Bind" . $stmt->error;
                }
            }
            break;
        case 'eliminar':
          
            break;

        default:
            # code...
            break;
    }
    echo json_encode([$validaciones,$equipos,$integrantesIDs,$integrantes]);
} else {
    header("Location:index.php");
}
