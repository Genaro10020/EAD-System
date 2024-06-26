<?php
include("conexionGhoner.php");

    function consultarCausas($grafica,$id_equipo,$anio,$mes){
        global $conexion;
        $resultado = [];
        $estado = false;
        $consulta = "SELECT * FROM causas WHERE grafica ='$grafica' AND id_equipo='$id_equipo' AND  anio ='$anio' AND  mes ='$mes' ORDER BY id DESC";
        $query = $conexion->query($consulta);
        if($query){
            $estado=true;
        }
        if ($query->num_rows > 0) {
            while ($fila = $query->fetch_assoc()) {
                 $resultado [] = $fila;
            }
        }

        return array($estado,$resultado,$grafica,$id_equipo,$anio,$mes);
    }

    function guardarCausa($tabla,$id_equipo,$equipo,$responsable,$causa,$anio,$mes,$dia){
        global $conexion;
        $answer = false;
        $guardar = "INSERT INTO causas (grafica,id_equipo,nombre_ead,responsable,causa,anio,mes,dia) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $conexion->prepare($guardar);
        if(!$stmt){return $conexion->error;}
        $stmt->bind_param("sisssiii",$tabla,$id_equipo,$equipo,$responsable,$causa,$anio,$mes,$dia);
        if(!$stmt->execute()){return $stmt->error;}
        $answer = true;
        return $answer;
    }

    function actualizarCausa($id,$responsable,$causa,$dia){
        global $conexion;
        $answer = false;
        $actualizar = "UPDATE causas SET responsable = ?, causa = ?, dia = ? WHERE id = ?";
        $stmt = $conexion->prepare($actualizar);
        if(!$stmt){return $conexion->error;}
        $stmt->bind_param("ssii",$responsable,$causa,$dia,$id);
        if(!$stmt->execute()){return $conexion->error;}
        $answer = true;
        return $answer;
    }

    function eliminarCausa($id){
        global $conexion;
        $delete = "DELETE FROM causas WHERE id =?";
        $stmt = $conexion->prepare($delete);
        if(!$stmt){
         return "Error al preprar la consulta".$conexion->error;
        }
        $stmt->bind_param("i",$id);
        if($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                return "No se encontró ninguna sesión con el ID proporcionado";
            }
        }else{
         return "Error en los parametros".$stmt->error;
        }
     }
?>