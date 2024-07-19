<?php
include("conexionGhoner.php");

    
        function consultarCriterios(){
            global $conexion;
            $resultado = [];
            $estado = false;
            $consulta = "SELECT * FROM criterios";
                $stmt = $conexion->prepare($consulta);
                if(!$stmt){
                    $estado = "Error al preparar ".$conexion->error;
                    return array($estado, $resultado);
                }
                if (!$stmt->execute()) {
                    $estado = "Error en la ejecución de la sentencia SQL:".$stmt->error;
                    return array($estado, $resultado);
                }
                $estado = true;
                $datos=$stmt->get_result();
                while ($fila=$datos->fetch_array()){ 
                    $resultado [] = $fila;
                }
            
            $stmt->close();
            $conexion->close();
            return array($estado, $resultado);
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