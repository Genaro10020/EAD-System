<?php
include("conexionGhoner.php");

        function consultarPreguntas(){
            global $conexion;
            $etapas = [];
            $resultado = [];
            $estado = false;
            $consulta = "SELECT * FROM preguntas";
            $query = $conexion->query($consulta);
            if ($query) {
                $estado = true;
                if ($query->num_rows > 0) {
                    while ($fila = $query->fetch_assoc()) {
                        $etapa = $fila['etapa'];
                        if (!isset($resultado[$etapa])) {
                            $resultado[$etapa] = []; // Crear nueva entrada para la etapa si no existe
                            $sumas[$etapa]['puntos_reales'] = 0;
                            $sumas[$etapa]['puntos_maximos'] = 0; // Agregar clave para la suma de preguntas
                            $sumas[$etapa]['ponderacion'] = intval($fila['peso']); // Agregar clave para la suma de preguntas
                        }
                        $resultado[$etapa][] = $fila;
                    }
                }
            }
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