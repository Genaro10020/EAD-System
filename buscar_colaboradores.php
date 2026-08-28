<?php

header('Content-Type: application/json; charset=utf-8');
require 'conexionBDSugerencias.php';

$busqueda = isset($_GET['q']) ? $_GET['q'] : '';

if (strlen($busqueda) > 0) {
    $query = "SELECT id, colaborador, numero_nomina FROM usuarios_colocaboradores_sugerencias WHERE colaborador LIKE ? LIMIT 10";
    
    if ($stmt = $conexion->prepare($query)) {
        $param = "%" . $busqueda . "%";
        $stmt->bind_param("s", $param);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $colaboradores = array();
        while ($fila = $resultado->fetch_assoc()) {
            $colaboradores[] = $fila;
        }
        
        echo json_encode($colaboradores);
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error en la consulta']);
    }
} else {
    echo json_encode([]);
}

$conexion->close();
?>