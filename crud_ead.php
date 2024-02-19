<?php
session_start();
if (isset($_SESSION['nombre'])) {
    $arreglo = json_decode(file_get_contents('php://input'), true);
    include("conexionGhoner.php");
    header('Content-Type: application/json');
    $accion = $arreglo['accion'];
    $resultado = [];
    switch ($accion) {
        case 'consultar':
           $consulta = "SELECT * FROM equipos_ead";
           $result = $conexion->query($consulta);
           if ($result) {
            $resultado[0] = true;
                while ($fila = $result->fetch_array()) {
                   
                   
                    $resultado[] = $fila;
                }
           }else{
            $resultado[0] = false;
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
                $resultado[0] = "Error en Bind" . $conexion->error;
            } else {
                $stmt->bind_param("sssssssssss", $nombre, $planta, $area, $proceso, $lider_equipo, $coordinador, $jefe_area, $ing_proceso, $ing_calidad, $supervisor,$ids_integrantes);
                if ($stmt->execute()) {
                    $resultado[0] = true;
                    $id_integrante=json_decode($ids_integrantes,true);
                    include("conexionBDSugerencias.php");
                    foreach($id_integrante as $elemento ){
                        $update = "UPDATE usuarios_colocaboradores_sugerencias SET equipo_ead=? WHERE id=?";
                        $stmt=$conexion->prepare($update);
                        if($stmt!==false){
                            $resultado[1] =true;
                            $stmt->bind_param("si",$nombre,$elemento);
                            $stmt->execute();
                            $stmt->close();
                        }else{
                            $resultado[1] ="Error al actualizar: ".$conexion->error;
                        }
                    }

                } else {
                    $resultado[0] = "Error en Bind" . $stmt->error;
                }
            }
            break;
        case 'eliminar':
          
            break;

        default:
            # code...
            break;
    }
    echo json_encode($resultado);
} else {
    header("Location:index.php");
}
