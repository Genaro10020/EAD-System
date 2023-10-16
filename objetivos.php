<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        include("conexionGhoner.php");
        header('Content-Type: application/json');
        
        $resultado = [];
        $accion = $arreglo['accion'];

        if($accion == "Consultar"){
            $consulta = "SELECT * FROM objetivos";
            $query = $conexion->query($consulta);
                while ($datos = mysqli_fetch_array($query))
                {
                    $resultado[] = $datos;
                }
        }else if($accion=="Insertar"){
        
                    
        }else{
            
        }
                    

        echo json_encode($resultado);
}else{
         header("Location:index.php");
}
?>