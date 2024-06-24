<?php
include("conexionGhoner.php");

    function consultarJuntasArranque($id_equipo){
        $resultado = [];
        $estado = false;
        global $conexion; 
        $consulta = "SELECT * FROM juntas_arranque WHERE id_equipo = '$id_equipo' ORDER BY id DESC";
        $respuesta = $conexion->query($consulta);
        if($respuesta){
            $estado = true;
            while ($dato = $respuesta->fetch_assoc()){
                $resultado[] = $dato;
            }
        }
        $conexion->close();
        return array($estado,$resultado);
    }

    function consultarDetallesForo($id){
    }

    function consultarEADxPlantaxArea($planta,$area){
    }


    function actualizarMision($id,$nuevoNombre){  
    }

    function eliminarMision($id){
    }
?>