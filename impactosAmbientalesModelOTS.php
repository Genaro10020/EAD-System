<?php
include("conexionOTS.php");

function consultarImpactoAmbiental(){

    global $conexion;

    $resultado = [];
    $estado = false;

    $consulta = "SELECT * FROM impacto_ambiental ORDER BY id DESC";

    $query = $conexion->query($consulta);

    if ($query) {

        while ($datos = mysqli_fetch_assoc($query)) {
            $resultado[] = $datos;
        }
        $estado = true;
    }
    return [$resultado, $estado];
}

?>