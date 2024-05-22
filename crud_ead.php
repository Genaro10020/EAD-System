<?php
session_start();
if (isset($_SESSION['nombre'])) {
    $arreglo = json_decode(file_get_contents('php://input'), true);
    include("conexionGhoner.php");
    header('Content-Type: application/json');
    $accion = $arreglo['accion'];
    $validaciones = [];
    $PlantasAreasEADs = array();
    $equipos = array();
    $integrantesIDs = array(); 
    $integrantes= array();  
   
    switch ($accion) {
        case 'consultar':
        if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario']=='Coordinador'){
            $area =  $_SESSION['area'];
            $consulta = "SELECT * FROM equipos_ead WHERE area ='$area' ORDER BY id DESC";
        }else{
            $consulta = "SELECT * FROM equipos_ead ORDER BY id DESC";
        }
        
        $result = $conexion->query($consulta);
    
        if ($result) {
        $validaciones[0] = true;
        $validaciones[1] = false;
        include("conexionBDSugerencias.php");
        if($result->num_rows>0){
            while ($fila = $result->fetch_array()) {
                $idEquipo = $fila['id'];
                if(!isset($equipos[$idEquipo])){
                    $integrantes[$idEquipo] = []; 
                }
                $equipos[$idEquipo][] = $fila;
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

        }else{
            $validaciones[1] = true; 
        }
    } else {
        $validaciones[0] = false;
    }
    break;
    case 'consutarEAD':
        $id_ead=$arreglo['id_ead'];
        $consulta = "SELECT * FROM equipos_ead WHERE id ='$id_ead'";
        $result = $conexion->query($consulta);
        if($result){
            $validaciones[0] = true;
                if($fila= $result->num_rows>0){
                    $fila = $result->fetch_assoc();
                    $integrantesIDs = json_decode($fila['integrantes'],true);
                        include("conexionBDSugerencias.php");
                            if (!empty($integrantesIDs) && is_array($integrantesIDs)) {
                                foreach ($integrantesIDs as $idIntegrante){
                                    $consultaIntegrantes = "SELECT * FROM usuarios_colocaboradores_sugerencias WHERE id = '$idIntegrante'";
                                    $resultIntegrantes = $conexion->query($consultaIntegrantes);
                                    if($resultIntegrantes){
                                        $validaciones[1] = true;
                                        if ($resultIntegrantes->num_rows > 0) {
                                            while ($datos = $resultIntegrantes->fetch_assoc()) {
                                                $integrantes[] = $datos; // Agregar datos al array usando $idEAD como clave
                                            }
                                        }
                                    }else{
                                        $validaciones[1] = false;
                                    }
                                }
                            }
                }

        }else{
            $validaciones[0] = false;
        }
           
        

    break;
    case 'consultarPlantasEADs':
          //$PlantasAreasEADs['areas'][] = $row['area'];
            //$PlantasAreasEADs['areas'] = array_unique($PlantasAreasEADs['areas']);
        $consulta = "SELECT planta FROM equipos_ead";
        $result = $conexion->query($consulta);
        if ($result) {
            foreach ($result as $row) {
                $PlantasAreasEADs['plantas'][] = $row['planta'];
               
            }
            $PlantasAreasEADs['plantas'] = array_unique($PlantasAreasEADs['plantas']);
            $validaciones[0] = true;
        } else {
            $validaciones[0] = $conexion->error;
        }
    break;
    case 'consultarAreasEADs':
        //$PlantasAreasEADs['areas'][] = $row['area'];
          //$PlantasAreasEADs['areas'] = array_unique($PlantasAreasEADs['areas']);
      $planta=$arreglo['planta'];
      $consulta = "SELECT area FROM equipos_ead WHERE planta='$planta'";
      $result = $conexion->query($consulta);
      if ($result) {
          foreach ($result as $row) {
              $PlantasAreasEADs['areas'][] = $row['area'];
             
          }
          $PlantasAreasEADs['areas'] = array_unique($PlantasAreasEADs['areas']);
          $validaciones[0] = true;
      } else {
          $validaciones[0] = $conexion->error;
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
            $lider = explode('<->', $lider_equipo);
            (int)$id_lider = $lider[0];
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

                    $update = "UPDATE usuarios_colocaboradores_sugerencias SET equipo_ead=?, lider_ead=? WHERE id=?";
                    $stmt=$conexion->prepare($update);
                    if($stmt!==false){
                        $validaciones[1] =true;
                        $eslider = "Si";
                        $stmt->bind_param("ssi",$ultimo_id_insertado,$eslider,$id_lider);
                        $stmt->execute();
                        $vacio = '';
                                foreach($id_integrante as $elemento ){
                                    $update = "UPDATE usuarios_colocaboradores_sugerencias SET equipo_ead=? WHERE id=? AND lider_ead=?";

                                    $stmt=$conexion->prepare($update);
                                    if($stmt!==false){
                                        $validaciones[1] =true;
                                        $stmt->bind_param("sis",$ultimo_id_insertado,$elemento,$vacio);
                                        $stmt->execute();
                                        $stmt->close();
                                    }else{
                                        $validaciones[1] ="Error al actualizar: ".$conexion->error;
                                    }
                                }
                    }else{
                        $validaciones[1] ="Error al actualizar: ".$conexion->error;
                    }


                    

                } else {
                    $validaciones[0] = "Error en Bind" . $stmt->error;
                }
            }
            break;
        case 'actualizar':

            $idEquipo = $arreglo['idEquipo'];
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
            $lider_anterior = $arreglo['lider_anterior'];
            
            $lider = explode('<->', $lider_equipo);
            (int)$id_lider = $lider[0];//nuevo lider

            $anterior = explode('<->',$lider_anterior);
            (int)$id_lider_anterior = $anterior[0];//anterior lider
            

            //Actualizo Equipos EAD    
            $actualizar = "UPDATE equipos_ead SET nombre_ead = ?,planta = ?,area = ? ,proceso = ?,lider_equipo = ?,coordinador = ?,jefe_area = ?,ing_procesos = ?,ing_calidad = ?,supervisor = ?,integrantes = ? WHERE id = ?";
            $stmt = $conexion->prepare($actualizar);
            if($stmt){
                $validaciones[0] = true;
                $stmt->bind_param('sssssssssssi',$nombre, $planta, $area, $proceso, $lider_equipo, $coordinador, $jefe_area, $ing_proceso, $ing_calidad, $supervisor,$ids_integrantes,$idEquipo);
                $stmt->execute();
                $stmt->close();
                    include("conexionBDSugerencias.php");
                    //eliminado el lider anterior
                    $update = "UPDATE usuarios_colocaboradores_sugerencias SET lider_ead=? WHERE id=?";
                    $stmt = $conexion->prepare($update);
                    if($stmt){
                        $validaciones[1] = true;
                        $limpiar = '';
                        $stmt->bind_param("si",$limpiar,$id_lider_anterior);
                        $stmt->execute(); 
                         //insertando nuevo lider
                             $update = "UPDATE usuarios_colocaboradores_sugerencias SET equipo_ead=?, lider_ead=? WHERE id=?";
                             $stmt = $conexion->prepare($update);
                            if($stmt){
                                $validaciones[4] = true;
                                $eslider = "Si";
                                $stmt->bind_param("ssi",$idEquipo,$eslider,$id_lider);
                                $stmt->execute(); 
                                        //Elimino el id a todos los integrantes para posteriormente colocarles el ID nuevamente pero ya con los nuevos integrantes (Evito que no se me escape ningun integrante)
                                        $update = "UPDATE usuarios_colocaboradores_sugerencias SET equipo_ead=? WHERE equipo_ead=? AND lider_ead=?";//si es lider y es elijido en otro equipo seguira de lider anterior hasta que se cambiado por otro integrante donde el es lider
                                        $stmt = $conexion->prepare($update);
                                        if($stmt){
                                            $validaciones[3] = true;
                                            $nulo = null;
                                            $vacio = '';
                                            $stmt->bind_param("sis",$nulo,$idEquipo,$vacio);
                                            $stmt->execute(); 
                                            $stmt->close();
                                            $id_integrante = json_decode($ids_integrantes,true);
                                            foreach($id_integrante as $elemento ){//ahora a cada elemento le agrego el id del equipo. tanto a los nuevo como los existes, por eso limpio antes.
                                                $validaciones[] =$elemento;
                                                $update = "UPDATE usuarios_colocaboradores_sugerencias SET equipo_ead=? WHERE id=? AND lider_ead=?";//si es lider y es escogico en otro equipo por accidente evito colocar el id del nuevo equipo y se sigue manteniendo como lider
                                                $stmt=$conexion->prepare($update);
                                                if($stmt!==false){
                                                    $validaciones[2] =true;
                                                    $stmt->bind_param("sis",$idEquipo,$elemento,$vacio);
                                                    $stmt->execute();
                                                    $stmt->close();
                                                }else{
                                                    $validaciones[2] ="Error al actualizar: ".$conexion->error;
                                                }
                                            }
                                        }else{
                                            $validaciones[3] = "Error al limpiar id equipo". $conexion->error;
                                        }
                            }else{
                                $validaciones[4] = "Error al limpiar id equipo". $conexion->error;
                            }
                    }else{
                        $validaciones[1] = "Error al limpiar al lider anterior". $conexion->error;
                    }

            }else{
                $validaciones[0] = "Error en actualizar ".$conexion->error;
            }
        break;
        case 'eliminar':
            $idEquipo=$arreglo['id_equipo'];
            $delete = "DELETE FROM equipos_ead WHERE id = ?";
            $stmt = $conexion->prepare($delete);
            if($stmt){
                $validaciones[0] = true;
                $stmt->bind_param("i",$idEquipo);
                $stmt->execute();
                $stmt->close();
                include("conexionBDSugerencias.php");
                $actualizar = "UPDATE usuarios_colocaboradores_sugerencias SET equipo_ead = ? WHERE equipo_ead = ?";
                $stmt = $conexion->prepare($actualizar);
                if($stmt){
                    $validaciones[1] = true;
                    $nulo = null;
                    $stmt->bind_param("si",$nulo,$idEquipo);
                    $stmt->execute();
                    $stmt->close();
                }else{
                    $validaciones[1] = "no se actualizo la tabla colaboradores ".$conexion->error;
                }

            }else{
                $validaciones[0] = "No se elimino el equipo".$conexion->error;
            }
           
            break;
        default:
            $validaciones[] = "No existe esa opción";
            break;
    }
    $conexion->close();
    echo json_encode([$validaciones,$equipos,$integrantesIDs,$integrantes,$PlantasAreasEADs]);
} else {
    header("Location:index.php");
}
