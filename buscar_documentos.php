<?php
session_start();
header("Content-Type: application/json");
require_once "conexionGhoner.php"; 

$variables = json_decode(file_get_contents('php://input'), true);
$respuesta = [];

$tipo_archivo = $variables['tipo_archivo'] ?? '';
$fecha_ruta = $variables['fecha_ruta'] ?? '';
$id_equipo = $variables['id_equipo'] ?? '';
$area = '';

if ($tipo_archivo === 'Presentacion') {
    
    $proyectos_map = [];
    $proyecto_viejo = "Sin Proyecto"; 

    if (!empty($id_equipo)) {
        $consulta = "SELECT nombre_proyecto, anio, periodo FROM gestion_sesiones WHERE id_equipo = ? AND nombre_proyecto IS NOT NULL AND nombre_proyecto != ''";
        $stmt = $conexion->prepare($consulta);
        
        if ($stmt) {
            $stmt->bind_param("i", $id_equipo);
            $stmt->execute();
            $res = $stmt->get_result();
            
            while ($fila = $res->fetch_assoc()) {
                $a = $fila['anio'] ? $fila['anio'] : '';
                $p = $fila['periodo'] ? $fila['periodo'] : '';
                
                if ($a !== '' && $p !== '') {
                    $proyectos_map[$a][$p] = $fila['nombre_proyecto'];
                } 
                if ($fila['nombre_proyecto'] != '') {
                    $proyecto_viejo = $fila['nombre_proyecto'];
                }
            }
            $stmt->close();
        }
    }

    $rutaBase = "documentoSession/" . $id_equipo;
    
    if (is_dir($rutaBase)) {
        $iterador = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rutaBase));
        
        foreach ($iterador as $archivo) {
            if ($archivo->isFile()) {
                $rutaCompleta = str_replace('\\', '/', $archivo->getPathname());
                
                $posicionBase = strpos($rutaCompleta, "documentoSession/");
                if ($posicionBase !== false) {
                    $rutaRelativa = substr($rutaCompleta, $posicionBase);
                    $partes = explode('/', $rutaRelativa);
                    
                    if (count($partes) === 3) {
                        $respuesta[] = [
                            'ruta' => $rutaRelativa,
                            'proyecto' => $proyecto_viejo,
                            'anio_periodo' => '' 
                        ];
                    } 
                    else if (count($partes) >= 5) {
                        $anio = $partes[2];
                        $periodo = $partes[3];
                        
                        $nombre_proy = isset($proyectos_map[$anio][$periodo]) ? $proyectos_map[$anio][$periodo] : "Sin Proyecto";
                        
                        $respuesta[] = [
                            'ruta' => $rutaRelativa,
                            'proyecto' => $nombre_proy,
                            'anio_periodo' => $anio . " - " . $periodo
                        ];
                    }
                }
            }
        }
    }
    
} else if ($tipo_archivo === 'Capacitacion' || $tipo_archivo === 'Por Fecha' || $tipo_archivo === 'EvidenciaFoto' || $tipo_archivo === 'DefinicionProyectos') {
    if($_SESSION['tipo_acceso']=="Admin"){
        $area = isset($variables['area']) ? $variables['area'] : $_SESSION['area'];
    } else {
        $area = $_SESSION['area'];
    }

    if($tipo_archivo === 'Capacitacion' || $tipo_archivo === 'Por Fecha'){
        $ruta = "documentoscapacitacion/".$area."/".$fecha_ruta;
    }else if($tipo_archivo === 'EvidenciaFoto'){
        $ruta = "evidenciacapacitacion/".$area."/".$fecha_ruta;
    }else if($tipo_archivo === 'DefinicionProyectos'){
        $ruta = "documentosdefinicionproyectos/".$area;
    }
    
    if (is_dir($ruta)){
        $gestor = opendir($ruta);
        while (($archivo = readdir($gestor)) !== false)  {
            if (is_file($ruta."/".$archivo)) {
                $respuesta [] = $ruta."/".$archivo;
            }    
        }
        closedir($gestor);
    }
}

echo json_encode($respuesta);
?>