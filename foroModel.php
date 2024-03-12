<?php
include("conexionGhoner.php");

    function consultar(){
   
    }

    function insertar(){
   
    }

    function actualizarEstatus($id_foro,$nuevoEstatus){
        global $conexion;
        $estado = false;
        $update = "UPDATE foros SET estatus=? WHERE id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("si", $nuevoEstatus, $id_foro);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }

    function eliminar(){
       
    }
?>