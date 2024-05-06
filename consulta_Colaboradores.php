<?php
session_start();
if (isset($_SESSION['nombre'])) {
    $arreglo = json_decode(file_get_contents('php://input'), true);
    include("conexionBDSugerencias.php");
    header('Content-Type: application/json');

    $resultado = [];
    //Verificar SI existe usuario
    $buscar_colaborador= $arreglo['buscar_colaborador'];
    $consulta = "SELECT * FROM usuarios_colocaboradores_sugerencias WHERE colaborador LIKE '%$buscar_colaborador%' || numero_nomina LIKE '%$buscar_colaborador%' ORDER BY id DESC ";
    $query = $conexion->query($consulta);
    if (mysqli_num_rows($query) > 0) {
        $resultado['Colaboradores'] = array();
        while ($dato = mysqli_fetch_array($query)) {
            $resultado['Colaboradores'][] = $dato;
        }
    }
    echo json_encode($resultado);
} else {
    header("Location:index.php");
}
