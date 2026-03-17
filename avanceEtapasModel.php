<?php
include("conexionGhoner.php");

    function consultarEtapas($metodologia){
        global $conexion;
        $etapas = [];
        $resultado = [];
        $estado = false;
        $consulta = "SELECT * FROM avance_etapas WHERE metodologia='$metodologia'";
        $query = $conexion->query($consulta);
        if ($query) {
            $estado = true;
            if ($query->num_rows > 0) {
                while ($fila = $query->fetch_assoc()) {
                    $resultado[] = $fila;
                }
            }
        }
        return array($estado, $resultado);
    }

    function insertar(){
   
    }

    function actualizarEstatus(){

    }

    function eliminar(){
       
    }
?>