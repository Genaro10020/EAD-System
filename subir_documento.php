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
    } else if ($tipo_archivo === 'Capacitacion' || $tipo_archivo === 'EvidenciaFoto') {
        if($_SESSION['tipo_acceso']=="Admin"){

            

            if (isset($_POST['area']) && !empty($_POST['area'])) {
                // Si 'area' está definida en POST y no está vacía
                 $area = $_POST['area'];
            } else {
                // Si 'area' no está definida en POST o está vacía
                $area = $_SESSION['area'];
                /* $area = isset($_SESSION['area']) ? $_SESSION['area'] : null */;  // O un valor por defecto
            }
            $fecha_ruta = $_POST['fecha_ruta'];
            if($tipo_archivo === 'Capacitacion'){
                $ruta = "documentoscapacitacion/".$area."/".$fecha_ruta."/";//AREA/FECHA
            }else if($tipo_archivo === 'EvidenciaFoto'){
                $ruta = "evidenciacapacitacion/".$area."/".$fecha_ruta."/";//AREA/FECHA
            }
        } 

        
    }


     // Contar archivos totales
    $countfiles = count($_FILES['files']['name']);
    //$suma=$countfiles + $cantidad;
    //verificar si existe directorio de$ruta = "sample/ruta/newfolder";
    if (!file_exists($ruta)) {
        mkdir($ruta, 0777, true);
    }

    // Ciclo todos los archivos
    for($index = 0;$index < $countfiles;$index++){
        if(isset($_FILES['files']['name'][$index]) && $_FILES['files']['name'][$index] != '')
        {
            // Nombre del archivo
            $filename = $_FILES['files']['name'][$index];
            // Obtener la extención del archivo
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            // Validar extensiones permitidas
            if($tipo_archivo === 'Capacitacion' || $tipo_archivo === 'Presentacion'){
                $valid_ext = array("pdf","doc","docx","ppt","pptx","xls","xlsx","rar","zip");
            }else if($tipo_archivo === 'EvidenciaFoto'){
                $valid_ext = array("png","jpg","jpeg");
            }
            
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