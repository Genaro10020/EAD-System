<?php
include("conexionOTS.php");

function consultarImpactoAmbiental()
{

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

function consultarCatalogoImpactoAspectoAmbiental()
{
    global $conexion;

    $resultado = [];
    $estado = false;

    $consulta = $conexion->prepare("SELECT * FROM catalogo_impactos_y_aspectos_ambientales ORDER BY id DESC;");
    $consulta->execute();
    $result = $consulta->get_result();

    if (!$consulta) {
        return;
    }

    while ($dato = $result->fetch_assoc()) {
        $resultado[] = $dato;
    }
    $estado = true;

    return [$resultado, $estado];
}

function consultarFactoresConversion()
{
    global $conexion;
    $resultado = [];
    $estado = false;

    $consulta = $conexion->prepare("SELECT * FROM factores_conversion ORDER BY id DESC;");
    $consulta->execute();
    $result = $consulta->get_result();

    if (!$consulta) {
        return;
    }

    while ($dato = $result->fetch_assoc()) {
        $resultado[] = $dato;
    }

    $estado = true;

    return [$resultado, $estado];
}

?>