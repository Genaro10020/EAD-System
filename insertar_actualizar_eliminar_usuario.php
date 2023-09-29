<?php
session_start();
$arreglo = json_decode(file_get_contents('php://input'), true);
include("conexionGhoner.php");
header('Content-Type: application/json');
$resultado = "";
$accion=$arreglo['accion'];
    if($accion=="insertar"){
            $nombre=$arreglo['nombre'];
            $nomina=$arreglo['nomina'];
            $contrasena=$arreglo['contrasena'];
            $planta=$arreglo['planta'];
            $area=$arreglo['area'];
            $subarea=$arreglo['subarea'];
            $usuario=$arreglo['usuario'];
            $acceso=$arreglo['acceso'];


                //Verificar SI existe usuario
            $insertar = "INSERT INTO usuarios  (id,nombre,nomina,contrasena,planta,area,subarea,tipo_usuario,tipo_acceso) VALUES ('','$nombre','$nomina','$contrasena','$planta','$area','$subarea','$usuario','$acceso')";
            $query = $conexion->query($insertar);
            if ($query) {
                $resultado = $query;
            } else {
                $resultado = "Error en la consulta: " . mysqli_error($conexion);
            }
    }else if($accion=="actualizar"){
        $id = $arreglo['id'];
        $nombre=$arreglo['nombre'];
        $nomina=$arreglo['nomina'];
        $contrasena=$arreglo['contrasena'];
        $planta=$arreglo['planta'];
        $area=$arreglo['area'];
        $subarea=$arreglo['subarea'];
        $usuario=$arreglo['usuario'];
        $acceso=$arreglo['acceso'];

        $update = "UPDATE usuarios SET nombre='$nombre',nomina='$nomina',contrasena='$contrasena',planta='$planta',area='$area',subarea='$subarea',tipo_usuario='$usuario',tipo_acceso='$acceso' WHERE id='$id'";
        $query = $conexion->query($update);
        if($query){
            $resultado=$query;
           
        }else{
            $resultado= "Error en php query actualizar".mysqli_error($conexion);
        }
        $conexion->close();
    }else if($accion=="eliminar"){
        $id = $arreglo['id'];
        $eliminar = "DELETE FROM usuarios WHERE id='$id'";
        $query = $conexion->query($eliminar);
        if($query){
            $resultado =$query;
        }else{
            $resultado = "Error en php query eliminar ". mysqli_error($conexion);
        }

    }else{
        $resultado = "No se encontro esa accion";
    }


echo json_encode($resultado);
?>