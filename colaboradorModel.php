<?php
include("conexionBDSugerencias.php");

    function consultar(){
   
    }

    function insertarColaborador($nombre,$nomina,$password,$planta){
        global $conexion;
        $insertar = "INSERT INTO usuarios_colocaboradores_sugerencias (colaborador, numero_nomina, password, planta) VALUES (?,?,?,?)";
        $stmt = $conexion->prepare($insertar);
        if(!$stmt){
            return $conexion->error;
        }
        $stmt->bind_param("ssss", $nombre, $nomina, $password, $planta);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            $respuesta = true;
        }else{
            return $stmt->error;
        }
        return $respuesta;
    }

    function asignarAccesoTabla($id_ead,$id_criterio,$id_integrante){
        global $conexion;
            if($id_criterio==="" || $id_integrante===NULL){
                $id_criterio = NULL;
            }
        $update = "UPDATE usuarios_colocaboradores_sugerencias SET equipo_ead_grafica = ?, id_grafica_acceso = ? WHERE id=?";
        $stmt = $conexion->prepare($update);
        if(!$stmt){
            return $conexion->error;
        }
        $stmt->bind_param("iii", $id_ead, $id_criterio, $id_integrante);
        if($stmt->execute()){
            return true;
        }else{
            return $stmt->error;
        }
    }

    function desmarcarAccesoTabla($id_integrante, $id_ead){
        global $conexion;
        $equipo_ead_grafica = NULL;
        $id_criterio = NULL;
        $update = "UPDATE usuarios_colocaboradores_sugerencias SET equipo_ead_grafica = ?, id_grafica_acceso = ? WHERE id = ? AND equipo_ead_grafica=?";
        $stmt = $conexion->prepare($update);
        if(!$stmt){
            return $conexion->error;
        }
        $stmt->bind_param("ssii", $equipo_ead_grafica,$id_criterio,$id_integrante,$id_ead);
        if($stmt->execute()){
            return true;
        }else{
            return $stmt->error;
        }
    }

    function eliminar(){
       
    }
?>