<?php
include("conexionGhoner.php");
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

    function guardarForo($nombre_foro,$planta,$area,$ids_ead,$ids_evaluadores){
        global $conexion;
        $estado = [];
        $query = "INSERT INTO foros (nombre_foro,planta,area) VALUES (?,?,?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("sss", $nombre_foro,$planta,$area);
        if($stmt->execute()){//guardo el foro
            $estado[0] = true;
            $ultimo_id = $conexion->insert_id;// tomo el id nuevo creado.
            foreach ($ids_ead as $id_ead) {
                $query2="UPDATE equipos_ead SET id_foro=? WHERE id=?";
                $stmt = $conexion->prepare($query2);
                $stmt -> bind_param('ii',$ultimo_id,$id_ead); //insertando el id del foro en cada equipo
                if($stmt ->execute()){
                    $estado[1] = true;
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

    function actualizarMision($id,$nuevoNombre){
        global $conexion;
        $estado = false;
        $update = "UPDATE misiones SET nombre=? WHERE  id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("si", $nuevoNombre, $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }



    function eliminarMision($id){
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