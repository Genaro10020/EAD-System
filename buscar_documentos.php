<?php
session_start();
header("Content-Type: application/json");
$variables = json_decode(file_get_contents('php://input'), true);
$respuesta = [];
//ruta para buacar

$tipo_archivo=$variables['tipo_archivo'];
$fecha_ruta=$variables['fecha_ruta'];
$id_equipo=$variables['id_equipo'];
$area = '';
if($tipo_archivo === 'Presentacion'){
    $ruta = "documentoSession/".$id_equipo;
}else if($tipo_archivo === 'Capacitacion' || $tipo_archivo === 'Por Fecha'){
    if($_SESSION['tipo_usuario']=="Admin"){
        if(isset($variables['area'])){
                $area=$variables['area'];
            }else{
                $area = $_SESSION['area'];
            }
    }else{
        $area = $_SESSION['area'];
    }
    $ruta = "documentoscapacitacion/".$area."/".$fecha_ruta;
}




if (is_dir($ruta)){
    // Abre un gestor de directorios para la ruta indicada
    $gestor = opendir($ruta);

    // Recorre todos los archivos del directorio
    while (($archivo = readdir($gestor)) !== false)  {
        // Solo buscamos archivos sin entrar en subdirectorios
        if (is_file($ruta."/".$archivo)) {
                //$respuesta [] =  "http://localhost/EAD-System/".$ruta."/".$archivo;
                $respuesta [] =  $ruta."/".$archivo;
        }    
    }
    // Cierra el gestor de directorios
    closedir($gestor);
} else {
    $respuesta = [];
}
echo json_encode($respuesta);
?>