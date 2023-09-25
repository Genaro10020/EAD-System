<?php
session_start();
$arreglo = json_decode(file_get_contents('php://input'), true);
include("conexionGhoner.php");
header('Content-Type: application/json');
$accion = $arreglo['accion'];
$nuevo = $arreglo['nuevo_tipo'];

$resultado = "";  

switch ($accion) {
    case 'insertar':
        $insertar = "INSERT INTO tipo_usuario_ead (tipo_usuario) VALUES ('$nuevo')";
        $query=$conexion->query($insertar);
        if($query){
            $resultado = $query;
        }
        break;
    case 'eliminar':
            $usuario = $arreglo['usuario'];
            $delete = "DELETE FROM tipo_usuario_ead WHERE tipo_usuario='$usuario'";
            $query=$conexion->query($delete);
            if($query){
                $resultado = $query;
            }
            break;
    
    default:
        # code...
        break;
}
    //Verificar SI existe usuario
   
/*$consulta = "SELECT * FROM plantas_ead";
$query = $conexion->query($consulta);
if (mysqli_num_rows($query) > 0) {
    $resultado['Plantas'] = array();
    while ($dato = mysqli_fetch_array($query)) {
        $resultado['Plantas'][] = $dato;
    }
}

$consulta = "SELECT * FROM areas_ead";
$query = $conexion->query($consulta);
if (mysqli_num_rows($query) > 0) {
    $resultado['Areas'] = array();
    while ($dato = mysqli_fetch_array($query)) {
        $resultado['Areas'][] = $dato;
    }
}

$consulta = "SELECT * FROM subareas_ead";
$query = $conexion->query($consulta);
if (mysqli_num_rows($query) > 0) {
    $resultado['Subareas'] = array();
    while ($dato = mysqli_fetch_array($query)) {
        $resultado['Subareas'][] = $dato;
    }
}

$consulta = "SELECT * FROM tipo_usuario_ead";
$query = $conexion->query($consulta);
if (mysqli_num_rows($query) > 0) {
    $resultado['TiposUsuario'] = array();
    while ($dato = mysqli_fetch_array($query)) {
        $resultado['TiposUsuario'][] = $dato['tipo_usuario'];
    }
}


$consulta = "SELECT * FROM usuarios_ead ORDER BY id DESC ";
$query = $conexion ->query($consulta);
if(mysqli_num_rows($query) > 0){
    $resultado['Usuarios'] = array();
    while($dato = mysqli_fetch_array($query)){
        $resultado['Usuarios'][] = $dato;
    }
}*/
     
echo json_encode($resultado);
?>