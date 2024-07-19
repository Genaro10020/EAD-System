<?php
session_start();
if(isset($_SESSION['nombre'])){
$arreglo = json_decode(file_get_contents('php://input'), true);
include("conexionGhoner.php");
header('Content-Type: application/json');
$resultado = [];
$accion=$arreglo['accion'];
    if ($accion=="consultar") {
        $consulta = "SELECT * FROM evaluadores";
        $query = $conexion->query($consulta);
            if (mysqli_num_rows($query) > 0){
                while ($dato = mysqli_fetch_array($query)) {
                    $resultado []= $dato;
                }
        }
    }else if($accion=="insertar"){
            $nombre=$arreglo['nombre'];
            $nomina=$arreglo['nomina'];
            $contrasena=$arreglo['contrasena'];
            $correo=$arreglo['correo'];

            $insertar = "INSERT INTO evaluadores (nombre,nomina,contrasena,correo) VALUES (?,?,?,?)";
            $stmt = $conexion->prepare($insertar);
            $stmt->bind_param("ssss",$nombre,$nomina,$contrasena,$correo);
            if ($stmt->execute()) {
                $resultado = true;
            } else {
                $resultado = "Error en la consulta: " . $conexion->error;
            }
    }else if($accion=="actualizar"){
            $id = $arreglo['id_evaluador'];
            $nombre=$arreglo['nombre'];
            $nomina=$arreglo['nomina'];
            $contrasena=$arreglo['contrasena'];
            $correo=$arreglo['correo'];

        $update = "UPDATE evaluadores SET nombre=?,nomina=?,contrasena=?,correo=? WHERE id=?";
        $stmt= $conexion->prepare($update);
        $stmt->bind_param("ssssi",$nombre,$nomina,$contrasena,$correo,$id);
        if($stmt->execute()){
            $resultado = true;
        }else{
            $resultado= "Error en php query actualizar".mysqli_error($conexion);
        }
        $conexion->close();
    }else if($accion=="eliminar"){
        $id = $arreglo['id_evaluador'];
        $eliminar = "DELETE FROM evaluadores WHERE id='$id'";
        $query = $conexion->query($eliminar);
        if($query){
            $resultado =$query;
        }else{
            $resultado = "Error en php query eliminar ". mysqli_error($conexion);
        }
    }else{
        $resultado = "No se encontro esa acción";
    }

    echo json_encode($resultado);

}else{
    header("Location:index.php");
}
?>