<?php
session_start();

// Para almacenar la ruta de los archivos cargados
$files_arr = array();

if(isset($_FILES['files']['name'])){

///////////////////////////header("Content-Type: application/json");
$cantidad=0;
$suma=0;
$tipo_archivo = $_POST['tipo_archivo'];


if ($tipo_archivo === 'Presentacion') {
    $id = $_POST['id_equipo'];
    $ruta = "documentoSession/".$id."/";
} else if ($tipo_archivo === 'Capacitacion') {
    $area = $_SESSION['area'];
    $fecha_ruta = $_POST['fecha_ruta'];
    $ruta = "documentoscapacitacion/".$area."/".$fecha_ruta."/";//AREA/FECHA
} else {
    
}
// Contar archivos totales
$countfiles = count($_FILES['files']['name']);
//$suma=$countfiles + $cantidad;
//verificar si existe directorio de$ruta = "sample/ruta/newfolder";
if (!file_exists($ruta)) {
    mkdir($ruta, 0777, true);
}

// Ciclo todos los archivos
    for($index = 0;$index < $countfiles;$index++)
            {
                if(isset($_FILES['files']['name'][$index]) && $_FILES['files']['name'][$index] != '')
                    {
                            // Nombre del archivo
                            $filename = $_FILES['files']['name'][$index];
                            // Obtener la extención del archivo
                            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                            // Validar extensiones permitidas
                            $valid_ext = array("png","jpeg","jpg","pdf","doc","docx","ppt","pptx","xls","xlsx","rar","zip");
                            // Revisar extension
                            if(in_array($ext, $valid_ext)){
                              
                            $filename = str_replace(" ","_", $filename);
                            $newfilename = $filename;
                            $ruta_y_doc= $ruta.$newfilename;
                            // Eliminado Espacios al Nombre
        
                                // Subir archivos
                                if(move_uploaded_file($_FILES['files']['tmp_name'][$index],$ruta_y_doc))
                                {
                                    $files_arr[] = $ruta_y_doc;
                                }
                        }
                    }
            }

}

echo json_encode($files_arr);
?>