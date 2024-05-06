<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        include("conexionGhoner.php");
        header('Content-Type: application/json');
        $resultado = "";
        $departamento = $arreglo['departamento'];
        $id = $arreglo['id'];

                        if($departamento=="Planta"){
                        //Verificar SI existe usuario
                        $delete = "DELETE FROM plantas WHERE id='$id'";
                        $query = $conexion->query($delete);
                        if ($query) {
                            $resultado = $query;
                        } else {
                            $resultado = "Error en la consulta: " . mysqli_error($conexion);
                        }
                        
                        }else if($departamento=="Area"){
                                    //Verificar SI existe usuario
                                    $delete = "DELETE FROM areas WHERE id='$id'";
                                    $query = $conexion->query($delete);
                                    if ($query) {
                                        $resultado = $query;
                                    } else {
                                        $resultado = "Error en la consulta: " . mysqli_error($conexion);
                                    }

                        }else if($departamento=="Subarea"){
                                    //Verificar SI existe usuario
                                    $delete = "DELETE FROM subareas WHERE id='$id'";
                                    $query = $conexion->query($delete);
                                    if ($query) {
                                        $resultado = $query;
                                    } else {
                                        $resultado = "Error en la consulta: " . mysqli_error($conexion);
                                    }

                        }else{
                            $resultado = "El controlador no encontro".$departamento;
                        }
                

        echo json_encode($resultado);
}else{
    header("Location:index.php");
}
?>