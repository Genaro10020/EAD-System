<?php
include("conexionGhoner.php");

    function consultarProyectos($area, $anio, $idsEquipos){
        global $conexion;
        $etapas = [];
        $resultado = [];
/* 
        $idsEquiposArray = json_decode($idsEquipos); */
        $cantidad= count($idsEquipos);
        for ($i=0; $i < $cantidad; $i++) { 
            $idEquipo=$idsEquipos[$i];
            $consulta = "SELECT * FROM kpis_proyectos  WHERE id_equipo='$idEquipo' AND  anio='$anio' ORDER BY `id_equipo`,`anio`,`semana`;";
                $query = $conexion->query($consulta);
                if ($query) {
                    if ($query->num_rows > 0) {
                        while ($fila = $query->fetch_assoc()) {
                            $resultado[] = $fila;
                        }
                    }
                }
        }

        
        return $resultado;
    }

    function insertar(){
   
    }

    function actualizarEstatus(){

    }

    function eliminar(){
       
    }
?>